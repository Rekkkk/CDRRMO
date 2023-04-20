<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\CdrrmoController;
use App\Http\Controllers\GuidelineController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\DisasterController;
use App\Http\Controllers\EvacuationCenterController;
use App\Http\Controllers\RecordEvacueeController;
use App\Http\Controllers\ReportAccidentController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticationController::class)->group(function (){
    Route::post('/', 'authUser')->name('login');

    Route::group(['middleware' => 'check.login'], function(){
        Route::view('/', 'authentication/authUser')->name('home');
    });
});

Route::group(['prefix' => 'resident', 'middleware' => 'guest'], function(){

    Route::group(['prefix' => 'reportAccident'], function(){
        Route::controller(ReportController::class)->group(function (){
            Route::get('/viewReport', 'displayGReport')->name('GdisplayReport');
            Route::post('/addReport', 'addReport')->name('GaddReport');
        });
    });

    Route::controller(GuestController::class)->group(function (){
        Route::get('/dashboard', 'dashboard')->name('Gdashboard');
        Route::get('/eligtasGuideline', 'guestEligtasGuideline')->name('Gguideline');
        Route::get('/eligtasGuideline/guideline/{guidelineId}', 'guestEligtasGuide')->name('Gguide');
        Route::get('/evacuationCenter', 'guestEvacuationCenter')->name('Gevacuationcenter');
        Route::get('/reportAccident', 'guestReportAccident')->name('Greport');
        Route::get('/hotlineNumber', 'guestHotlineNumber')->name('Ghotlinenumber');
        Route::get('/statistics', 'guestStatistics')->name('Gstatistics');
        Route::get('/about', 'guestAbout')->name('Gabout');
    });
});

Route::group(['prefix' => 'cdrrmo', 'middleware' => 'auth', 'ensure.token'], function(){
    
    Route::group(['prefix' => 'eligtasGuideline'], function(){
        Route::controller(GuidelineController::class)->group(function (){
            Route::post('/guide/addGuide{guidelineId}', 'addGuide')->name('Caguide');
            Route::put('/guide/updateGuide/{guideId}', 'updateGuide')->name('Cupdateguide');
            Route::get('/guide/removeGuide/{guideId}', 'removeGuide')->name('Cremoveguide');

            Route::post('/guideline/addGuideline', 'addGuideline')->name('Caguideline');
            Route::put('/guideline/updateGuideline/{guidelineId}', 'updateGuideline')->name('Cupdateguideline');
            Route::get('/guideline/removeGuideline/{guidelineId}', 'removeGuideline')->name('Cremoveguideline');
        });
    });

    Route::group(['prefix' => 'evacuationCenter'], function(){
        Route::controller(EvacuationCenterController::class)->group(function (){
            Route::post('/registerEvacuation', 'registerEvacuationCenter')->name('Cregisterevacuation');
            Route::put('/updateEvacuation/{evacuationId}', 'updateEvacuationCenter')->name('Cupdateevacuation');
            Route::delete('/removeEvacuation/{evacuationId}', 'removeEvacuationCenter')->name('Cremoveevacuation');
        });
    });

    Route::group(['prefix' => 'disaster'], function(){
        Route::controller(DisasterController::class)->group(function (){
            Route::post('/registerDisaster', 'registerDisaster')->name('Cregisterdisaster');
            Route::put('/updateDisaster/{disasterId}', 'updateDisaster')->name('Cupdatedisaster');
            Route::delete('/removeDisaster/{disasterId}', 'removeDisaster')->name('Cremovedisaster');
        });
    });

    Route::group(['prefix' => 'barangay'], function(){
        Route::controller(BarangayController::class)->group(function (){
            Route::post('/registerBarangay', 'registerBarangay')->name('Cregisterbarangay');
            Route::put('/updateBarangay/{barangayId}', 'updateBarangay')->name('Cupdatebarangay');
            Route::delete('/removeBarangay/{barangayId}', 'removeBarangay')->name('Cremovebarangay');
        });
    });

    Route::group(['prefix' => 'reportAccident'], function(){
        Route::controller(ReportAccidentController::class)->group(function (){
            Route::post('/addReport', 'addReport')->name('CaddReport');
            Route::get('/viewReport', 'displayCReport')->name('CdisplayReport');
            Route::post('/approveReport/{reportId}', 'approveReport')->name('CapproveReport');
            Route::delete('/removeReport/{reportId}', 'removeReport')->name('CremoveReport');
        });
    });

    Route::group(['prefix' => 'recordEvacuee'], function(){
        Route::controller(RecordEvacueeController::class)->group(function (){
            Route::post('/recordEvacueeInfo', 'recordEvacueeInfo')->name('Crecordevacueeinfo');
        });
    });

    Route::controller(CdrrmoController::class)->group(function (){
        Route::get('/dashboard', 'dashboard')->name('Cdashboard');
        Route::get('/recordEvacuee', 'recordEvacuee')->name('Crecordevacuee');
        Route::get('/disaster', 'disaster')->name('Cdisaster');
        Route::get('/eligtasGuideline', 'eligtasGuideline')->name('Cguideline');
        Route::get('/eligtasGuideline/guide/{guideline_id}', 'eligtasGuide')->name('Cguide');
        Route::get('/barangay', 'barangay')->name('Cbarangay');
        Route::get('/evacuationManage', 'evacuationManage')->name('Cevacuationmanage');
        Route::get('/evacuationCenter', 'evacuationCenter')->name('Cevacuation');
        Route::get('/hotlineNumbers', 'hotlineNumbers')->name('CNumbers');
        Route::get('/statistics', 'statistics')->name('Cstatistics');
        Route::get('/reportAccident', 'reportAccident')->name('Creport');
        Route::get('/about', 'about')->name('Cabout');
        Route::get('/logout', 'logout')->name('Clogout');
    });
});