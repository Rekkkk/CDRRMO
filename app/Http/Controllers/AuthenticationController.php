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

        return back()->withInput()->with('error', 'Incorrect User Credentials.');
    }

    public function checkUserAccount()
    {
        if (auth()->check()) {
            $userAuthenticated = auth()->user();

            if ($userAuthenticated->isDisable == 1) {
                session()->flush();
                auth()->logout();
                return back()->withInput()->with('error', 'Your account has been Disabled.');
            }

            if ($userAuthenticated->isSuspend == 1) {
                $suspendTime = Carbon::parse($userAuthenticated->suspendTime)->format('F j, Y H:i:s');

                if ($userAuthenticated->suspendTime < Carbon::now()->format('Y-m-d H:i:s')) {
                    $this->user->find($userAuthenticated->id)->update([
                        'status' => 'Active',
                        'isSuspend' => 0,
                        'suspendTime' => null
                    ]);
                } else {
                    auth()->logout();
                    session()->flush();
                    return back()->withInput()->with('error', 'Your account has been suspended until ' . $suspendTime);
                }
            }

            $this->logActivity->generateLog('Logged In');
            $userOrganization = $userAuthenticated->organization;

            if ($userOrganization == "CDRRMO") {
                return redirect('/cdrrmo/dashboard')->with('success', "Welcome to " . $userOrganization . " Panel.");
            } else if ($userOrganization == "CSWD") {
                return redirect('/cswd/dashboard')->with('success', "Welcome to " . $userOrganization . " Panel.");
            }
        }

        return back();
    }

    public function recoverAccount()
    {
        return view('authentication.forgotPassword');
    }

    public function findAccount(Request $request)
    {
        $verifyEmailValidate = Validator::make($request->all(), [
            'email' => 'required|email|exists:user'
        ]);

        if ($verifyEmailValidate->passes()) {
            try {
                $token = Str::random(64);
                DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
                Mail::to($request->email)->send(new SendResetPasswordLink(['token' => $token]));

                return back()->with('success', 'We have sent you an email with a link to reset your password.');
            } catch (\Exception $e) {
                return back()->with('error', 'Something went wrong, Please try again.');
            }
        }

        return back()->with('warning', 'Email address is not existing.');
    }

    public function resetPasswordForm($token)
    {
        return view('authentication.resetPasswordForm', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $resetPasswordValidate = Validator::make($request->all(), [
            'email' => 'required|email|exists:user',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        if ($resetPasswordValidate->passes()) {
            try {
                $updatePassword = DB::table('password_resets')
                    ->where([
                        'email' => $request->email,
                        'token' => $request->token
                    ])
                    ->first();
                if (!$updatePassword) {
                    return back()->withInput()->with('error', 'Unauthorized Token!');
                }

                User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
                DB::table('password_resets')->where(['email' => $request->email])->delete();
                return redirect('/')->with('success', 'Your password has been changed.');
            } catch (\Exception $e) {
                return back()->with('error', 'Something went wrong, Please try again.');
            }
        }

        return back()->withInput()->with('error', 'Please fill out correctly.');
    }

    public function logout()
    {
        $roleName = auth()->user()->organization;
        $this->logActivity->generateLog('Logged Out');
        auth()->logout();
        session()->flush();

        return redirect('/')->with('success', 'Logged out ' . $roleName . ' Panel.');
    }
}
