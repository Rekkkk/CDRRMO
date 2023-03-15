<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CdrrmoController extends Controller
{
    public function dashboard(){
        $this->middleware('ensure.token');
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
        $male = DB::table('typhoon')->pluck('male');
        $female = DB::table('typhoon')->pluck('female');

        return view('CDRRMO.statistics', ['male' => $male, 'female' => $female]);
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
