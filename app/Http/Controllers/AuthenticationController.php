<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{

    public function landingPage()
    {
        return view('authentication.authUser');
    }

    public function authUser(Request $request)
    {
        $userValidated = $request->validate([
            'email' => 'required|email',
            "password" => 'required',
        ]);

        if (Auth::attempt($userValidated)) {
            $request->session()->regenerate();
            return $this->checkUserRole();
        } else
            return back()->withInput()->with('message', 'Incorrect Admin Panel Password!');
    }

    public function checkUserRole()
    {
        if (Auth::check()) {

            if (Auth::user()->user_role == 1)
                return redirect('/cdrrmo/dashboard')->with('message', 'Welcome to CDRRMO Panel');

            if (Auth::user()->user_role == 2)
                return redirect('/cswd/dashboard')->with('message', 'Welcome to CSWD Panel');
        }

        return back();
    }
}
