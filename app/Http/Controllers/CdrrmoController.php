<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CdrrmoController extends Controller
{

    public function authAdmin(Request $request){

        $validated = $request->validate([
            'id' => ['required'],
            "password" => ['required'],
        ]);
       
        if(auth()->attempt($validated)){
            $request->session()->regenerate();
            
            return redirect('/cdrrmo/dashboard')->with('message', 'Welcome to Admin Panel');
        }

        return back()->with('message', 'Incorrect Password!');
    }
    
    public function dashboard(){
        return view('CDRRMO.dashboard');
    }

    public function addData(){
        return view('CDRRMO.addData');
    }

    public function eligtasGuidelines(){
        return view('CDRRMO.eligtasGuidelines');
    }

    public function evacuationCenter(){
        return view('CDRRMO.evacuationCenter');
    }

    public function hotlineNumbers(){
        return view('CDRRMO.hotlineNumbers');
    }

    public function statistics(){
        return view('CDRRMO.statistics');
    }

    public function about(){
        return view('CDRRMO.about');
    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Successfully Logout Admin Panel');
    }
}
