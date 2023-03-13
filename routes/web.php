<?php

use App\Http\Controllers\CdrrmoController;
use App\Http\Controllers\GuessController;
use Illuminate\Support\Facades\Route;

Route::controller(GuessController::class)->group(function (){
    Route::get('/', 'landingPage')->name('login')->middleware('guest');
    Route::get('/resident/dashboard', 'dashboard')->name('Gdashboard');
    Route::get('/resident/eligtasGuidelines', 'guessEligtasGuidelines')->name('Gguidelines');
    Route::get('/resident/hotlineNumbers', 'guessHotlineNumbers')->name('GNumbers');
    Route::get('/resident/statistics', 'guessStatistics')->name('Gstatistics');
    Route::get('/resident/about', 'guessAbout')->name('Gabout');
});

Route::controller(CdrrmoController::class)->group(function (){
    Route::post('/cdrrmo', 'authAdmin')->middleware('guest');
    Route::get('/cdrrmo/dashboard', 'dashboard')->name('Cdashboard')->middleware('auth');
    Route::get('/cdrrmo/addData', 'addData')->name('CaddData')->middleware('auth');
    Route::get('/cdrrmo/eligtasGuidelines', 'eligtasGuidelines')->name('Cguidelines')->middleware('auth');
    Route::get('/cdrrmo/evacuationCenter', 'evacuationCenter')->name('Cevacuation')->middleware('auth');
    Route::get('/cdrrmo/hotlineNumbers', 'hotlineNumbers')->name('CNumbers')->middleware('auth');
    Route::get('/cdrrmo/statistics', 'statistics')->name('Cstatistics')->middleware('auth');
    Route::get('/cdrrmo/about', 'about')->name('Cabout')->middleware('auth');
    Route::post('/cdrrmo/logout', 'logout')->name('Clogout')->middleware('auth');
});