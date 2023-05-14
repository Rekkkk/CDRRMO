<?php

namespace App\Http\Controllers;

use App\Models\ActivityUserLog;
use Carbon\Carbon;
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
            'password' => 'required'
        ]);

        if (Auth::attempt($userValidated)) {
            return $this->checkUserRole();
        } else
            return back()->withInput()->with('message', 'Incorrect Admin Panel Password!');
    }

    public function checkUserRole()
    {
        if (Auth::check()) {

            if (Auth::user()->user_role == 1) {
                $currentDate = Carbon::now();
                $todayDate = $currentDate->toDayDateTimeString();

                ActivityUserLog::create([
                    'user_id' => Auth::user()->id,
                    'email' => Auth::user()->email,
                    'user_role' => Auth::user()->user_role,
                    'role_name' => Auth::user()->role_name,
                    'activity' => 'Logged In',
                    'date_time' => $todayDate,
                ]);

                return redirect('/cdrrmo/dashboard')->with('message', 'Welcome to CDRRMO Panel');
            }


            if (Auth::user()->user_role == 2) {
                $currentDate = Carbon::now();
                $todayDate = $currentDate->toDayDateTimeString();

                ActivityUserLog::create([
                    'user_id' => Auth::user()->id,
                    'email' => Auth::user()->email,
                    'user_role' => Auth::user()->user_role,
                    'role_name' => Auth::user()->role_name,
                    'activity' => 'Logged In',
                    'date_time' => $todayDate,
                ]);

                return redirect('/cswd/dashboard')->with('message', 'Welcome to CSWD Panel');
            }


            if (Auth::user()->user_role == 3) {
                $currentDate = Carbon::now();
                $todayDate = $currentDate->toDayDateTimeString();

                ActivityUserLog::create([
                    'user_id' => Auth::user()->id,
                    'email' => Auth::user()->email,
                    'user_role' => Auth::user()->user_role,
                    'role_name' => Auth::user()->role_name,
                    'activity' => 'Logged In',
                    'date_time' => $todayDate,
                ]);
                
                return redirect('/developer/dashboard')->with('message', 'Welcome to Developer Panel');
            }
        }

        return back();
    }
}
