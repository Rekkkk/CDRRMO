<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityUserLog;

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
            return $this->checkUserRole();

        return back()->withInput()->with('message', 'Incorrect Password!');
    }

    public function checkUserRole()
    {
        if (auth()->check()) {
            $userRole = auth()->user()->user_role;
            $this->logActivity->generateLog('Logged In');

            if ($userRole == 'CDRRMO')
                return redirect('/cdrrmo/dashboard')->with('message', 'Welcome to CDRRMO Panel.');
            else if ($userRole == 'CSWD')
                return redirect('/cswd/dashboard')->with('message', 'Welcome to CSWD Panel.');
            else if ($userRole == 'Developer')
                return redirect('/developer/dashboard')->with('message', 'Welcome to Developer Panel.');
        }

        return back();
    }

    public function logout(Request $request)
    {
        $role_name = auth()->user()->user_role;
        $this->logActivity->generateLog('Logged Out');

        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Successfully Logged out ' . $role_name . ' Panel.');
    }
}
