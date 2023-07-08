<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use App\Mail\SendResetPasswordLink;
use Illuminate\Support\Facades\Mail;

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

            if ($userAuthenticated->isRestrict == 1) {
                session()->flush();
                auth()->logout();
                return back()->withInput()->with('error', 'Your account has been Restricted.');
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
        session()->flush();

        $userAccount = $this->user->where('email', $request->email)->first();

        if ($userAccount) {
            $obfuscatedEmail = Str::replaceFirst(
                '@',
                '@' . str_repeat('*', strlen($userAccount->email) - strpos($userAccount->email, '@') - 1),
                $userAccount->email
            );

            session()->put('userEmail', $userAccount->email);

            return response()->json(['status' => 1, 'account' => $obfuscatedEmail]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function sendResetPasswordLink()
    {
        $userEmail = session()->get('userEmail');

        try {
            //Mail::to($userEmail)->send(new SendResetPasswordLink());
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 1]);
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
