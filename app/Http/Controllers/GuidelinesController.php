<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuidelinesController extends Controller
{
    public function guidelines(){
        return view('CDRRMO.guidelines');
    }
}
