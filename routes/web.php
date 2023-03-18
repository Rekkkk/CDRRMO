<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CdrrmoController;
use App\Http\Controllers\GuidelinesController;
use App\Http\Controllers\GuessController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'check.login'], function(){
    Route::view('/', 'auth/authUser')->name('home');
});

Route::controller(GuessController::class)->group(function (){

    Route::controller(GuidelinesController::class)->group(function (){
        Route::get('/resident/eligtasGuidelines/guidelines', 'guidelines')->name('Gguide')->middleware('guest');
    });

    Route::get('/resident/dashboard', 'dashboard')->name('Gdashboard');
    Route::get('/resident/eligtasGuidelines', 'guessEligtasGuidelines')->name('Gguidelines');
    Route::get('/resident/hotlineNumbers', 'guessHotlineNumbers')->name('GNumbers');
    Route::get('/resident/statistics', 'guessStatistics')->name('Gstatistics');
    Route::get('/resident/about', 'guessAbout')->name('Gabout');
});

Route::controller(AuthenticationController::class)->group(function (){
    Route::post('/', 'authUser')->name('login');
});

Route::group(['middleware' => 'auth'], function(){

    Route::controller(GuidelinesController::class)->group(function (){
        Route::get('/cdrrmo/eligtasGuidelines/guidelines', 'guidelines')->name('Cguide');
    });

    Route::controller(CdrrmoController::class)->group(function (){
        Route::get('/cdrrmo/dashboard', 'dashboard')->name('Cdashboard');
        Route::get('/cdrrmo/addData', 'addData')->name('CaddData');
        Route::get('/cdrrmo/eligtasGuidelines', 'eligtasGuidelines')->name('Cguidelines');
        Route::get('/cdrrmo/evacuationCenter', 'evacuationCenter')->name('Cevacuation');
        Route::get('/cdrrmo/hotlineNumbers', 'hotlineNumbers')->name('CNumbers');
        Route::get('/cdrrmo/statistics', 'statistics')->name('Cstatistics');
        Route::get('/cdrrmo/about', 'about')->name('Cabout');
        Route::post('/cdrrmo/logout', 'logout')->name('Clogout');
    });
});



