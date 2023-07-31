<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use App\Mail\SendResetPasswordLink;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    private $user, $logActivity;

    public function __construct()
    {
        $this->user = new User;
        $this->logActivity = new ActivityUserLog;
    }

    public function landingPage()
    {
        return view('authentication.authUser');
    }

    public function authUser(Request $request)
    {
        if (auth()->attempt($request->only('email', 'password')))
            return $this->checkUserAccount();

        return back()->withInput()->with('warning', 'Incorrect User Credentials.');
    }

    public function checkUserAccount()
    {
        if (auth()->check()) {
            $userAuthenticated = auth()->user();

            if ($userAuthenticated->is_suspend == 1) {
                $suspendTime = Carbon::parse($userAuthenticated->suspend_time)->format('F j, Y H:i:s');

                if ($userAuthenticated->suspend_time <= Carbon::now()->format('Y-m-d H:i:s')) {
                    $this->user->find($userAuthenticated->id)->update([
                        'status' => 'Active',
                        'is_suspend' => 0,
                        'suspend_time' => null
                    ]);
                } else {
                    auth()->logout();
                    session()->flush();
                    return back()->withInput()->with('warning', 'Your account has been suspended until ' . $suspendTime);
                }
            }

            $this->logActivity->generateLog('Logged In');
            $userOrganization = $userAuthenticated->organization;

            return redirect("/" . Str::of($userOrganization)->lower() . "/dashboard")->with('success', "Welcome to " . $userOrganization . " Panel.");
        }

        return back();
    }

    public function recoverAccount()
    {
        return view('authentication.forgotPassword');
    }

    public function findAccount(Request $request)
    {
        $verifyEmailValidation = Validator::make($request->all(), [
            'email' => 'required|email|exists:user'
        ]);

        if ($verifyEmailValidation->passes()) {
            try {
                $token = Str::random(124);
                DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
                Mail::to($request->email)->send(new SendResetPasswordLink(['token' => $token]));

                return back()->with('success', 'We have sent you an email with a link to reset your password.');
            } catch (\Exception $e) {
                return back()->with('error', 'An error occurred while processing your request.');
            }
        }

        return back()->with('warning', 'Email address is not exist.');
    }

    public function resetPasswordForm($token)
    {
        return DB::table('password_resets')->where('token', $token)->exists()
            ? view('authentication.resetPasswordForm', compact('token'))
            : redirect('/')->with('warning', 'Token Expired.');
    }

    public function resetPassword(Request $request)
    {
        $resetPasswordValidation = Validator::make($request->all(), [
            'email' => 'required|email|exists:user',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        if ($resetPasswordValidation->passes()) {
            try {
                $tokenAuthorization = DB::table('password_resets')
                    ->where([
                        'email' => $request->email,
                        'token' => $request->token
                    ])
                    ->first();

                if (!$tokenAuthorization) {
                    return back()->withInput()->with('error', 'Unauthorized Token!');
                }

                $this->user->where('email', $request->email)->update(['password' => Hash::make($request->password)]);
                DB::table('password_resets')->where(['email' => $request->email])->delete();

                return redirect('/')->with('success', 'Your password has been changed.');
            } catch (\Exception $e) {
                return back()->with('error', 'An error occurred while processing your request.');
            }
        }

        return back()->withInput()->with('warning', $resetPasswordValidation->errors()->first());
    }

    public function logout()
    {
        $organization = auth()->user()->organization;
        $this->logActivity->generateLog('Logged Out');
        auth()->logout();
        session()->flush();

        return redirect('/')->with('success', 'Logged out ' . $organization . ' Panel.');
    }
}
