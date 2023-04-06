<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationController extends Controller
{

    public function landingPage(){
        return view('/auth/authUser');
    }
    
    public function authUser(Request $request){
        $validated = $request->validate([
            'id' => 'required',
            "password" => 'required',
        ]);
       
        if(auth()->attempt($validated)){
            $request->session()->regenerate();
            
            return redirect('/cdrrmo/dashboard')->with('message', 'Welcome to Admin Panel');
        }

        return back()->with('message', 'Incorrect Admin Panel Password!');
    }
}
