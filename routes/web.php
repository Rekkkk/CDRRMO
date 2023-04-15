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
        Route::get('/reportAccident', 'guessReportAccident')->name('Greport');
        Route::get('/hotlineNumbers', 'guessHotlineNumbers')->name('GNumbers');
        Route::get('/statistics', 'guessStatistics')->name('Gstatistics');
        Route::get('/about', 'guessAbout')->name('Gabout');
    });
});

Route::group(['prefix' => 'cdrrmo', 'middleware' => 'auth'], function(){

    Route::group(['prefix' => 'eligtasGuidelines'], function(){
        Route::controller(GuidelinesController::class)->group(function (){
            Route::post('/guide/addGuide', 'addGuide')->name('Caguide');
            Route::put('/guide/updateGuide/{guide_id}', 'updateGuide')->name('Cupdateguide');
            Route::delete('/guide/removeGuide/{guide_id}', 'removeGuide')->name('Cremoveguide');
            
            Route::post('/guidelines/addGuidelines', 'addGuidelines')->name('Caguidelines');
            Route::put('/guidelines/updateGuidelines/{guidelines_id}', 'updateGuidelines')->name('Cupdateguidelines');
            Route::delete('/guidelines/removeGuidelines/{guidelines_id}', 'removeGuidelines')->name('Cremoveguidelines');
        });
    });

    Route::group(['prefix' => 'evacuation'], function(){
        Route::controller(EvacuationCenterController::class)->group(function (){
            Route::post('/registerEvacuation', 'registerEvacuation')->name('Cregisterevacuation');
            Route::put('/updateEvacuation/{evacuation_id}', 'updateEvacuation')->name('Cupdateevacuation');
            Route::delete('/removeEvacuation/{evacuation_id}', 'removeEvacuation')->name('Cremoveevacuation');
        });
    });

    Route::group(['prefix' => 'disaster'], function(){
        Route::controller(DisasterController::class)->group(function (){
            Route::post('/registerDisaster', 'registerDisaster')->name('Cregisterdisaster');
            Route::put('/updateDisaster/{disaster_id}', 'updateDisaster')->name('Cupdatedisaster');
            Route::delete('/removeDisaster/{disaster_id}', 'removeDisaster')->name('Cremovedisaster');
        });
    });

    Route::group(['prefix' => 'baranggay'], function(){
        Route::controller(BaranggayController::class)->group(function (){
            Route::post('/registerBaranggay', 'registerBaranggay')->name('Cregisterbaranggay');
            Route::put('/updateBaranggay/{baranggay_id}', 'updateBaranggay')->name('Cupdatebaranggay');
            Route::delete('/removeBaranggay/{baranggay_id}', 'removeBaranggay')->name('Cremovebaranggay');
        });
    });

    Route::controller(CdrrmoController::class)->group(function (){
        Route::get('/dashboard', 'dashboard')->name('Cdashboard');
        Route::get('/addResident', 'addResident')->name('CaddResident');
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



