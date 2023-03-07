<?php

use App\Http\Controllers\CdrrmoController;
use App\Http\Controllers\GuessController;
use Illuminate\Support\Facades\Route;

Route::controller(GuessController::class)->group(function (){
    Route::get('/', 'landingPage')->name('login')->middleware('guest');
    Route::get('/resident/dashboard', 'dashboard');
    Route::get('/resident/eligtasGuidelines', 'guessEligtasGuidelines');
    Route::get('/resident/hotlineNumbers', 'guessHotlineNumbers');
    Route::get('/resident/statistics', 'guessStatistics');
    Route::get('/resident/about', 'guessAbout');
});

Route::controller(CdrrmoController::class)->group(function (){
    Route::post('/cdrrmo', 'authAdmin')->middleware('guest');
    Route::get('/cdrrmo/dashboard', 'dashboard')->middleware('auth');
    Route::get('/cdrrmo/addData', 'addData')->middleware('auth');
    Route::get('/cdrrmo/eligtasGuidelines', 'eligtasGuidelines')->middleware('auth');
    Route::get('/cdrrmo/evacuationCenter', 'evacuationCenter')->middleware('auth');
    Route::get('/cdrrmo/hotlineNumbers', 'hotlineNumbers')->middleware('auth');
    Route::get('/cdrrmo/statistics', 'statistics')->middleware('auth');
    Route::get('/cdrrmo/about', 'about')->middleware('auth');
    Route::post('/cdrrmo/logout', 'logout')->middleware('auth');
});