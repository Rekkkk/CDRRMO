<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\EvacueeController;
use App\Http\Controllers\GuidelineController;
use App\Http\Controllers\UserAccountsController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ReportAccidentController;
use App\Http\Controllers\EvacuationCenterController;

Route::controller(AuthenticationController::class)->group(function () {
    Route::post('/', 'authUser')->name('login');
    Route::get('/logout', 'logout')->name('logout.user');
    Route::get('/recoverAccount', 'recoverAccount')->name('recoverAccount');
    Route::get('/findAccount', 'findAccount')->name('findAccount');
    Route::get('/sendResetPasswordLink', 'sendResetPasswordLink')->name('sendResetPasswordLink');

    Route::middleware('check.login')->group(function () {
        Route::view('/', 'authentication/authUser')->name('home');
    });
});

Route::prefix('resident')->middleware('guest')->group(function () {
    Route::name('resident.')->group(function () {
        Route::name('report.')->prefix('reportAccident')->controller(ReportAccidentController::class)->group(function () {
            Route::get('/pendingIncidentReport', 'displayPendingReport')->name('pending');
            Route::get('/displayIncidentReport', 'displayIncidentReport')->name('display');
            Route::delete('/revertReport/{reportId}', 'revertAccidentReport')->name('revert');
            Route::put('/updateAttempt', 'updateUserAttempt')->name('update');
            Route::post('/addReport', 'addAccidentReport')->name('accident');
        });

        Route::prefix('eligtasGuideline')->controller(GuidelineController::class)->group(function () {
            Route::get('/', 'eligtasGuideline')->name('guideline');
            Route::get('/', 'eligtasGuideline')->name('guideline');
            Route::get('/guide/{guidelineId}', 'guide')->name('guide');
        });

        Route::controller(MainController::class)->group(function () {
            Route::get('/evacuationCenter', 'evacuationCenter')->name('evacuation.center');
            Route::get('/reportAccident', 'reportAccident')->name('display.report.accident');
            Route::get('/hotlineNumber', 'hotlineNumber')->name('hotline.number');
            Route::get('/about', 'about')->name('about');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::prefix('cswd')->middleware('check.cswd')->group(function () {
        Route::controller(MainController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard.cswd');
            Route::post('/generateEvacueeData', 'generateExcelEvacueeData')->name('generate.evacuee.data');
            Route::get('/evacuee', 'manageEvacueeInformation')->name('manage.evacuee.record');
            Route::get('/evacuationManage', 'evacuationManage')->name('manage.evacuation');
            Route::get('/evacuationCenter', 'evacuationCenter')->name('evacuation.center.locator');
        });

        Route::prefix('evacuee')->controller(EvacueeController::class)->group(function () {
            Route::get('/getEvacueeInfo', 'getEvacueeData')->name('get.evacuee.info');
            Route::get('/getArchivedEvacueeInfo/{disasterInfo}', 'getArchivedEvacueeInfo')->name('get.archived.evacuee.info');
            Route::post('/recordEvacueeInfo', 'recordEvacueeInfo')->name('record.evacuee');
            Route::put('/updateEvacueeInfo/{evacueeId}', 'updateEvacueeInfo')->name('update.evacuee.info');
            Route::patch('/updateEvacueeDateOut', 'updateEvacueeDateOut')->name('update.evacuee.dateout');
        });

        Route::prefix('evacuationCenter')->name('evacuation.center.')->controller(EvacuationCenterController::class)->group(function () {
            Route::get('/viewEvacuationCenter', 'evacuationCenterList')->name('display');
            Route::post('/registerEvacuation', 'registerEvacuationCenter')->name('register');
            Route::put('/updateEvacuation/{evacuationId}', 'updateEvacuationCenter')->name('update');
            Route::delete('/removeEvacuation/{evacuationId}', 'removeEvacuationCenter')->name('remove');
        });
    });

    Route::prefix('cdrrmo')->middleware('check.cdrrmo')->group(function () {
        Route::controller(MainController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard.cdrrmo');
            Route::get('/reportAccident', 'reportAccident')->name('display.report.accident');
            Route::get('/hotlineNumber', 'hotlineNumber')->name('hotline.number');
            Route::get('/about', 'about')->name('about');
        });

        Route::prefix('reportAccident')->name('report.')->controller(ReportAccidentController::class)->group(function () {
            Route::get('/displayPendingReport', 'displayPendingReport')->name('pending');
            Route::get('/displayIncidentReport', 'displayIncidentReport')->name('accident');
            Route::post('/approveReport/{reportId}', 'approveAccidentReport')->name('approve');
            Route::delete('/declineAccidentReport/{reportId}', 'declineAccidentReport')->name('decline');
            Route::delete('/removeAccidentReport/{reportId}', 'removeReportAccident')->name('remove');
        });
    });

    Route::prefix('eligtasGuideline')->controller(GuidelineController::class)->group(function () {
        Route::name('guideline.')->group(function () {
            Route::get('/', 'eligtasGuideline')->name('display');
            Route::post('/guideline/addGuideline', 'addGuideline')->name('add');
            Route::put('/guideline/updateGuideline/{guidelineId}', 'updateGuideline')->name('update');
            Route::get('/guideline/removeGuideline/{guidelineId}', 'removeGuideline')->name('remove');
        });

        Route::name('guide.')->group(function () {
            Route::get('/guide/{guidelineId}', 'guide')->name('display');
            Route::post('/guide/addGuide{guidelineId}', 'addGuide')->name('add');
            Route::put('/guide/updateGuide/{guideId}', 'updateGuide')->name('update');
            Route::get('/guide/removeGuide/{guideId}', 'removeGuide')->name('remove');
        });
    });

    Route::name('account.')->controller(UserAccountsController::class)->group(function () {
        Route::post('/createAccount', 'createAccount')->name('create');
        Route::get('/userProfile', 'userProfile')->name('display.profile');
        Route::put('/updateAccount/{userId}', 'updateAccount')->name('update');
        Route::get('/userAccount', 'userAccounts')->name('display.users');
        Route::put('/disableAccount/{userId}', 'disableAccount')->name('disable');
        Route::put('/enableAccount/{userId}', 'enableAccount')->name('enable');
        Route::put('/suspendAccount/{userId}', 'suspendAccount')->name('suspend');
        Route::put('/openAccount/{userId}', 'openAccount')->name('open');
        Route::get('/changePassword', 'changePassword')->name('change.password');
        Route::put('/resetPassword/{userId}', 'resetPassword')->name('reset.password');
        Route::post('/checkPassword', 'checkPassword')->name('check.password');
        Route::delete('/removeAccount/{userId}', 'removeAccount')->name('remove');
    });
});
