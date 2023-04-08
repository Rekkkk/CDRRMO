<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BaranggayController;
use App\Http\Controllers\CdrrmoController;
use App\Http\Controllers\GuidelinesController;
use App\Http\Controllers\GuessController;
use App\Http\Controllers\DisasterController;
use App\Http\Controllers\EvacuationCenterController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticationController::class)->group(function (){
    Route::post('/', 'authUser')->name('login');

    Route::group(['middleware' => 'check.login'], function(){
        Route::view('/', 'auth/authUser')->name('home');
    });
});

Route::group(['prefix' => 'resident', 'middleware' => 'guest'], function(){
    Route::controller(GuidelinesController::class)->group(function (){
        Route::get('/eligtasGuidelines/guidelines', 'guidelines')->name('Gguide');
    });

    Route::controller(GuessController::class)->group(function (){
        Route::get('/dashboard', 'dashboard')->name('Gdashboard');
        Route::get('/eligtasGuidelines', 'guessEligtasGuidelines')->name('Gguidelines');
        Route::get('/evacuationCenter', 'guessEvacuationCenter')->name('GEvacuation');
        Route::get('/hotlineNumbers', 'guessHotlineNumbers')->name('GNumbers');
        Route::get('/statistics', 'guessStatistics')->name('Gstatistics');
        Route::get('/about', 'guessAbout')->name('Gabout');
    });
});

Route::group(['prefix' => 'cdrrmo', 'middleware' => 'auth'], function(){

    Route::controller(GuidelinesController::class)->group(function (){
        Route::get('/eligtasGuidelines/guide/addGuide', 'addGuide')->name('Caguide');
        Route::get('/eligtasGuidelines/guidelines/addGuidelines', 'addGuidelines')->name('Caguidelines');
        Route::get('/eligtasGuidelines/guidelines/updateGuidelines/{guidelines_id}', 'updateGuidelines')->name('Cupdateguide');
        Route::get('/eligtasGuidelines/guidelines/removeGuidelines/{guidelines_id}', 'removeGuidelines')->name('Cremoveguide');
    });

    Route::controller(EvacuationCenterController::class)->group(function (){
        Route::get('/evacuation/registerEvacuation', 'registerEvacuation')->name('Cregisterevacuation');
        Route::get('/evacuation/updateEvacuation/{evacuation_id}', 'updateEvacuation')->name('Cupdateevacuation');
        Route::get('/evacuation/removeEvacuation/{evacuation_id}', 'deleteEvacuation')->name('Cremoveevacuation');
    });

    Route::controller(DisasterController::class)->group(function (){
        Route::get('/disaster/registerDisaster', 'registerDisaster')->name('Cregisterdisaster');
        Route::get('/disaster/updateDisaster/{disaster_id}', 'updateDisaster')->name('Cupdatedisaster');
        Route::get('/disaster/removeDisaster/{disaster_id}', 'deleteDisaster')->name('Cremovedisaster');
    });

    Route::controller(BaranggayController::class)->group(function (){
        Route::get('/disaster/registerBaranggay', 'registerBaranggay')->name('Cregisterbaranggay');
        Route::get('/disaster/updateBaranggay/{baranggay_id}', 'updateBaranggay')->name('Cupdatebaranggay');
        Route::get('/disaster/removeBaranggay/{baranggay_id}', 'deleteBaranggay')->name('Cremovebaranggay');
    });

    Route::controller(CdrrmoController::class)->group(function (){
        Route::get('/dashboard', 'dashboard')->name('Cdashboard');
        Route::get('/addData', 'addData')->name('CaddData');
        Route::get('/disaster', 'disaster')->name('Cdisaster');
        Route::get('/eligtasGuidelines', 'eligtasGuidelines')->name('Cguidelines');
        Route::get('/eligtasGuidelines/guide', 'eligtasGuide')->name('Cguide');
        Route::get('/baranggay', 'baranggay')->name('Cbaranggay');
        Route::get('/evacuationManage', 'evacuationManage')->name('Cevacuationmanage');
        Route::get('/evacuationCenter', 'evacuationCenter')->name('Cevacuation');
        Route::get('/hotlineNumbers', 'hotlineNumbers')->name('CNumbers');
        Route::get('/statistics', 'statistics')->name('Cstatistics');
        Route::get('/reportAccident', 'reportAccident')->name('Creport');
        Route::get('/about', 'about')->name('Cabout');
        Route::get('/logout', 'logout')->name('Clogout');
    });
});



