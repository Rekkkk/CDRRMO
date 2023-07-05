<?php

namespace App\Http\Controllers;

use App\Mail\SendResetPasswordLink;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

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
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials))
            return $this->checkUserAccount();

        return back()->withInput()->with('error', 'Incorrect User Credentials!');
    }

    public function checkUserAccount()
    {
        if (auth()->check()) {
            if (auth()->user()->isRestrict == 1) {
                session()->flush();
                auth()->logout();
                return back()->withInput()->with('error', 'Your account has been Restricted.');
            }

            if (auth()->user()->isSuspend == 1) {
                $suspendTime = Carbon::parse(auth()->user()->suspendTime)->format('F j, Y H:i:s');

                if (auth()->user()->suspendTime < Carbon::now()->format('Y-m-d H:i:s')) {
                    $this->user->find(auth()->user()->id)->update([
                        'status' => 'Active',
                        'isSuspend' => 0,
                        'suspendTime' => null
                    ]);
                    $this->logActivity->generateLog('Logged In');

                    return redirect('/dashboard')->with('success', "Welcome to " . auth()->user()->organization . " Panel.");
                } else {
                    auth()->logout();
                    session()->flush();

                    return back()->withInput()->with('error', 'Your account has been suspended until ' . $suspendTime);
                }
            } else {
                $this->logActivity->generateLog('Logged In');

                return redirect('/dashboard')->with('success', "Welcome to " . auth()->user()->organization . " Panel.");
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
        Session::flush();

        $userAccount = $this->user->where('email', $request->email)->get();

        $em   = explode("@", $userAccount->value('email'));
        $name = implode('@', array_slice($em, 0, count($em) - 1));
        $len  = floor(strlen($name) / 2);

        $userEmail  = substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);

        Session::put('userEmail', $userAccount->value('email'));

        if ($userAccount->isNotEmpty()) {
            return response()->json(['status' => 1, 'account' => $userEmail]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function sendResetPasswordLink()
    {
        $userEmail = Session::get('userEmail');

        try {
            Mail::to($userEmail)->send(new SendResetPasswordLink());
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 1]);
    }

    public function logout()
    {
        $role_name = auth()->user()->organization;
        $this->logActivity->generateLog('Logged Out');

        auth()->logout();
        session()->flush();

        return redirect('/')->with('success', 'Logged out ' . $role_name . ' Panel.');
    }
}
