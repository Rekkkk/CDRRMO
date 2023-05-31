<?php

namespace App\Http\Controllers;

class DeveloperController extends Controller
{
    public function dashboard()
    {
        return view('userpage.dashboard');
    }
}
