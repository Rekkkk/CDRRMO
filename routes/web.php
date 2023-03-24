<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CdrrmoController;
use App\Http\Controllers\GuidelinesController;
use App\Http\Controllers\GuessController;
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

    Route::controller(AnnouncementController::class)->group(function (){
        Route::get('/createAnnouncement', 'createAnnouncement')->name('CCreateAnnouncement');
        Route::get('/editAnnouncement/{announcement_id}', 'editAnnouncement')->name('CEditAnnouncement');
        Route::get('/updateAnnouncement/{announcement_id}', 'updateAnnouncement')->name('CUpdateAnnouncement');
        Route::get('/deleteAnnouncement/{announcement_id}', 'deleteAnnouncement')->name('CDeleteAnnouncement');
    });

    Route::controller(GuidelinesController::class)->group(function (){
        Route::get('/eligtasGuidelines/guidelines', 'guidelines')->name('Cguide');
    });

    Route::controller(CdrrmoController::class)->group(function (){
        Route::get('/dashboard', 'dashboard')->name('Cdashboard');
        Route::get('/addData', 'addData')->name('CaddData');
        Route::get('/eligtasGuidelines', 'eligtasGuidelines')->name('Cguidelines');
        Route::get('/evacuationCenter', 'evacuationCenter')->name('Cevacuation');
        Route::get('/hotlineNumbers', 'hotlineNumbers')->name('CNumbers');
        Route::get('/statistics', 'statistics')->name('Cstatistics');
        Route::get('/about', 'about')->name('Cabout');
        Route::get('/logout', 'logout')->name('Clogout');
    });
});



