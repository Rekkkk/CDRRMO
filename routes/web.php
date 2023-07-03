<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CswdController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CdrrmoController;
use App\Http\Controllers\EvacueeController;
use App\Http\Controllers\GuidelineController;
use App\Http\Controllers\UserAccountsController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ReportAccidentController;
use App\Http\Controllers\EvacuationCenterController;

Route::controller(AuthenticationController::class)->group(function () {
    Route::post('/', 'authUser')->name('login');
    Route::get('/logout', 'logout')->name('logout.user');

    Route::group(['middleware' => 'check.login'], function () {
        Route::view('/', 'authentication/authUser')->name('home');
    });
});

Route::group(['prefix' => 'resident', 'middleware' => 'guest'], function () {

    Route::group(['prefix' => 'reportAccident'], function () {
        Route::controller(ReportAccidentController::class)->group(function () {
            Route::get('/pendingIncidentReport', 'displayPendingReport')->name('pending.report.resident');
            Route::get('/displayIncidentReport', 'displayIncidentReport')->name('accident.report.resident');
            Route::delete('/revertReport/{reportId}', 'revertAccidentReport')->name('revert.report.resident');
            Route::put('/updateAttempt', 'updateUserAttempt')->name('update.report.resident');
            Route::post('/addReport', 'addAccidentReport')->name('report.accident.resident');
        });
    });

    Route::group(['prefix' => 'eligtasGuideline'], function () {
        Route::controller(GuidelineController::class)->group(function () {
            Route::get('/', 'eligtasGuideline')->name('guideline.resident');
            Route::get('/guide/{guidelineId}', 'guide')->name('guide.resident');
        });
    });

    Route::controller(MainController::class)->group(function () {
        Route::get('/evacuationCenter', 'evacuationCenter')->name('evacuation.center.resident');
        Route::get('/reportAccident', 'reportAccident')->name('display.report.accident.resident');
        Route::get('/hotlineNumber', 'hotlineNumber')->name('hotline.number.resident');
        Route::get('/about', 'about')->name('about.resident');
    });
});

Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => 'cdrrmo'], function () {
        Route::group(['prefix' => 'eligtasGuideline'], function () {
            Route::controller(GuidelineController::class)->group(function () {
                Route::get('/', 'eligtasGuideline')->name('guideline.cdrrmo');
                Route::post('/guide/addGuide{guidelineId}', 'addGuide')->name('add.guide.cdrrmo');
                Route::put('/guide/updateGuide/{guideId}', 'updateGuide')->name('update.guide.cdrrmo');
                Route::get('/guide/removeGuide/{guideId}', 'removeGuide')->name('remove.guide.cdrrmo');

                Route::get('/guide/{guidelineId}', 'guide')->name('guide.cdrrmo');
                Route::post('/guideline/addGuideline', 'addGuideline')->name('add.guideline.cdrrmo');
                Route::put('/guideline/updateGuideline/{guidelineId}', 'updateGuideline')->name('update.guideline.cdrrmo');
                Route::get('/guideline/removeGuideline/{guidelineId}', 'removeGuideline')->name('remove.guideline.cdrrmo');
            });
        });

        Route::group(['prefix' => 'reportAccident'], function () {
            Route::controller(ReportAccidentController::class)->group(function () {
                Route::get('/displayPendingReport', 'displayPendingReport')->name('pending.report.cdrrmo');
                Route::get('/displayIncidentReport', 'displayIncidentReport')->name('accident.report.cdrrmo');
                Route::post('/addReport', 'addAccidentReport')->name('report.accident.cdrrmo');
                Route::post('/approveReport/{reportId}', 'approveAccidentReport')->name('approve.report.cdrrmo');
                Route::delete('/declineAccidentReport/{reportId}', 'declineAccidentReport')->name('decline.report.cdrrmo');
                Route::delete('/removeAccidentReport/{reportId}', 'removeReportAccident')->name('remove.report.cdrrmo');
            });
        });

        Route::controller(MainController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard.cdrrmo');
            Route::post('/generateEvacueeData', 'generateExcelEvacueeData')->name('generate.evacuee.data.cdrrmo');
            Route::get('/reportAccident', 'reportAccident')->name('display.report.accident.cdrrmo');
            Route::get('/hotlineNumber', 'hotlineNumber')->name('hotline.number.cdrrmo');
            Route::get('/about', 'about')->name('about.cdrrmo');
        });

    });

    Route::group(['prefix' => 'cswd'], function () {

        Route::group(['prefix' => 'eligtasGuideline'], function () {
            Route::controller(GuidelineController::class)->group(function () {
                Route::get('/', 'eligtasGuideline')->name('guideline.cswd');
                Route::post('/guide/addGuide{guidelineId}', 'addGuide')->name('add.guide.cswd');
                Route::put('/guide/updateGuide/{guideId}', 'updateGuide')->name('update.guide.cswd');
                Route::get('/guide/removeGuide/{guideId}', 'removeGuide')->name('remove.guide.cswd');

                Route::get('/guide/{guidelineId}', 'guide')->name('guide.cswd');
                Route::post('/guideline/addGuideline', 'addGuideline')->name('add.guideline.cswd');
                Route::put('/guideline/updateGuideline/{guidelineId}', 'updateGuideline')->name('update.guideline.cswd');
                Route::get('/guideline/removeGuideline/{guidelineId}', 'removeGuideline')->name('remove.guideline.cswd');
            });
        });

        Route::group(['prefix' => 'evacuationCenter'], function () {
            Route::controller(EvacuationCenterController::class)->group(function () {
                Route::get('/viewEvacuationCenter', 'evacuationCenterList')->name('evacuation.center.cswd');
                Route::get('/evacuationCenterDetails/{evacuationId}', 'getEvacuationCenterDetails')->name('evacuation.center.detail.cswd');
                Route::post('/registerEvacuation', 'registerEvacuationCenter')->name('register.evacuation.center.cswd');
                Route::put('/updateEvacuation/{evacuationId}', 'updateEvacuationCenter')->name('update.evacuation.center.cswd');
                Route::delete('/removeEvacuation/{evacuationId}', 'removeEvacuationCenter')->name('remove.evacuation.center.cswd');
            });
        });

        Route::group(['prefix' => 'evacuee'], function () {
            Route::controller(EvacueeController::class)->group(function () {
                Route::get('/getEvacueeInfo', 'getEvacueeData')->name('get.evacuee.info.cswd');
                Route::get('/getArchivedEvacueeInfo/{disasterInfo}', 'getArchivedEvacueeInfo')->name('get.archived.evacuee.info.cswd');
                Route::post('/recordEvacueeInfo', 'recordEvacueeInfo')->name('record.evacuee.cswd');
                Route::put('/updateEvacueeInfo/{evacueeId}', 'updateEvacueeInfo')->name('update.evacuee.info.cswd');
                Route::patch('/updateEvacueeDateOut', 'updateEvacueeDateOut')->name('update.evacuee.dateout.cswd');
            });
        });

        Route::controller(MainController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard.cswd');
            Route::post('/generateEvacueeData', 'generateExcelEvacueeData')->name('generate.evacuee.data.cswd');
            Route::get('/evacuee', 'manageEvacueeInformation')->name('manage.evacuee.record.cswd');
            Route::get('/evacuationManage', 'evacuationManage')->name('manage.evacuation.cswd');
            Route::get('/evacuationCenter', 'evacuationCenter')->name('evacuation.center.locator.cswd');
        });
    });

    Route::controller(UserAccountsController::class)->group(function () {
        Route::post('/createUserAccount', 'createUserAccount')->name('create.account');
        Route::get('/userProfile', 'userProfile')->name('display.user.profile');
        Route::put('/updateAccount/{userId}', 'updateUserAccount')->name('update.account');
        Route::get('/userAccount', 'userAccounts')->name('display.user.accounts');
        Route::put('/restrictUser/{userId}', 'restrictUserAccount')->name('restrict.account');
        Route::put('/unrestrictUser/{userId}', 'unRestrictUserAccount')->name('unrestrict.account');
        Route::put('/suspendUser/{userId}', 'suspendUserAccount')->name('suspend.account');
        Route::put('/openAccount/{userId}', 'openUserAccount')->name('open.account');
        Route::delete('/removeAccount/{userId}', 'removeUserAccount')->name('remove.account');
    });
});
