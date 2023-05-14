<?php

namespace App\Http\Controllers;

use App\Models\ActivityUserLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperController extends Controller
{
    public function dashboard()
    {
        return view('userpage.dashboard');
    }

    public function logout(Request $request)
    {
        $currentDate = Carbon::now();
        $todayDate = $currentDate->toDayDateTimeString();

        ActivityUserLog::create([
            'user_id' => Auth::user()->id,
            'email' => Auth::user()->email,
            'user_role' => Auth::user()->user_role,
            'role_name' => Auth::user()->role_name,
            'activity' => 'Logged Out',
            'date_time' => $todayDate,
        ]);
        
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Successfully Logout Developer Panel');
    }
}
