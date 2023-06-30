<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    private $logActivity;

    public function __construct()
    {
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

        return back()->withInput()->with('message', 'Incorrect User Credentials!');
    }

    public function checkUserAccount()
    {
        if (auth()->check()) {
            $userRole = '';
            $suspendTime = Carbon::parse(auth()->user()->suspendTime)->format('F j, Y H:i:s');

            if (auth()->user()->isSuspend == 1) {
                if (auth()->user()->suspendTime < Carbon::now()->format('Y-m-d H:i:s')) {

                    DB::table('users')->where('id', auth()->user()->id)->update([
                        'status' => 'Active',
                        'isSuspend' => 0,
                        'suspendTime' => null
                    ]);

                    $userRole = auth()->user()->organization;
                    $this->logActivity->generateLog('Logged In');

                    if ($userRole == 'CDRRMO')
                        return redirect('/cdrrmo/dashboard')->with('message', 'Welcome to CDRRMO Panel.');
                    else if ($userRole == 'CSWD')
                        return redirect('/cswd/dashboard')->with('message', 'Welcome to CSWD Panel.');
                } else {
                    session()->flush();
                    auth()->logout();

                    return back()->withInput()->with('message', 'Your Account has been suspended until ' . $suspendTime);
                }
            } else {
                $userRole = auth()->user()->organization;
                $this->logActivity->generateLog('Logged In');

                if ($userRole == 'CDRRMO')
                    return redirect('/cdrrmo/dashboard')->with('message', 'Welcome to CDRRMO Panel.');
                else if ($userRole == 'CSWD')
                    return redirect('/cswd/dashboard')->with('message', 'Welcome to CSWD Panel.');
            }
        }

        return back();
    }

    public function logout(Request $request)
    {
        $role_name = auth()->user()->organization;
        $this->logActivity->generateLog('Logged Out');

        auth()->logout();
        session()->flush();

        return redirect('/')->with('message', 'Successfully Logged out ' . $role_name . ' Panel.');
    }
}
