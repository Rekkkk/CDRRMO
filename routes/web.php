<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\EvacueeController;
use App\Http\Controllers\GuidelineController;
use App\Http\Controllers\UserAccountsController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DisasterController;
use App\Http\Controllers\IncidentReportController;
use App\Http\Controllers\EvacuationCenterController;

Route::controller(AuthenticationController::class)->group(function () {
    Route::post('/', 'authUser')->name('login');
    Route::get('/logout', 'logout')->name('logout.user');
    Route::get('/recoverAccount', 'recoverAccount')->name('recoverAccount');
    Route::post('/findAccount', 'findAccount')->name('findAccount');
    Route::get('/resetPasswordForm/{token}', 'resetPasswordForm')->name('resetPasswordForm');
    Route::post('resetPassword', 'resetPassword')->name('resetPassword');

    Route::middleware('check.login')->group(function () {
        Route::view('/', 'authentication/authUser')->name('home');
    });
});

Route::prefix('resident')->middleware('guest')->group(function () {
    Route::name('resident.')->group(function () {
        Route::name('report.')->prefix('reportIncident')->controller(IncidentReportController::class)->group(function () {
            Route::get('/displayPendingIncidentReport', 'displayPendingIncidentReport')->name('pending');
            Route::get('/displayIncidentReport', 'displayIncidentReport')->name('display');
            Route::delete('/revertIncidentReport/{reportId}', 'revertIncidentReport')->name('revert');
            Route::put('/updateAttempt', 'updateUserAttempt')->name('update');
            Route::post('/createIncidentReport', 'createIncidentReport')->name('accident');
        });

        Route::prefix('eligtasGuideline')->controller(GuidelineController::class)->group(function () {
            Route::get('/', 'eligtasGuideline')->name('guideline');
            Route::get('/', 'eligtasGuideline')->name('guideline');
            Route::get('/guide/{guidelineId}', 'guide')->name('guide');
        });

        Route::controller(MainController::class)->group(function () {
            Route::get('/evacuationCenter', 'evacuationCenterLocator')->name('evacuation.center.locator');
            Route::get('/incidentReport', 'incidentReport')->name('display.incident.report');
            Route::get('/hotlineNumber', 'hotlineNumber')->name('hotline.number');
            Route::get('/about', 'about')->name('about');
        });

        Route::controller(EvacuationCenterController::class)->group(function () {
            Route::get('/viewEvacuationCenter/{operation}', 'getEvacuationData')->name('evacuation.center.get');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::prefix('cswd')->middleware('check.cswd')->group(function () {
        Route::controller(MainController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard.cswd');
            Route::post('/generateEvacueeData', 'generateExcelEvacueeData')->name('generate.evacuee.data');
            Route::get('/evacuee', 'manageEvacueeInformation')->name('manage.evacuee.record');
            Route::get('/manageEvacuation', 'manageEvacuation')->name('manage.evacuation');
            Route::get('/evacuationCenter', 'evacuationCenterLocator')->name('evacuation.center.locator');
        });

        Route::prefix('disaster')->name('disaster.')->controller(DisasterController::class)->group(function () {
            Route::get('/disasterInformation', 'displayDisasterInformation')->name('display');
            Route::post('/createDisasterData', 'createDisasterData')->name('create');
            Route::put('/updateDisaster/{disasterId}', 'updateDisasterData')->name('update');
            Route::patch('/removeDisaster/{disasterId}', 'removeDisasterData')->name('remove');
            Route::patch('/changeDisasterStatus/{disasterId}', 'changeDisasterStatus')->name('change.status');
        });

        Route::prefix('evacuee')->name('evacuee.info.')->controller(EvacueeController::class)->group(function () {
            Route::get('/getEvacueeInfo', 'getEvacueeData')->name('get');
            Route::get('/getArchivedEvacueeInfo/{disasterInfo}', 'getArchivedEvacueeInfo')->name('get.archived');
            Route::post('/recordEvacueeInfo', 'recordEvacueeInfo')->name('record');
            Route::put('/updateEvacueeInfo/{evacueeId}', 'updateEvacueeInfo')->name('update');
            Route::patch('/updateEvacueeDateOut', 'updateEvacueeDateOut')->name('update.dateout');
        });

        Route::prefix('evacuationCenter')->name('evacuation.center.')->controller(EvacuationCenterController::class)->group(function () {
            Route::get('/viewEvacuationCenter/{operation}', 'getEvacuationData')->name('get');
            Route::post('/createEvacuationCenter', 'createEvacuationCenter')->name('create');
            Route::put('/updateEvacuation/{evacuationId}', 'updateEvacuationCenter')->name('update');
            Route::delete('/removeEvacuation/{evacuationId}', 'removeEvacuationCenter')->name('remove');
            Route::patch('/changeEvacuationStatus/{evacuationId}', 'changeEvacuationStatus')->name('change.status');
        });
    });

    Route::prefix('cdrrmo')->middleware('check.cdrrmo')->group(function () {
        Route::controller(MainController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard.cdrrmo');
            Route::get('/incidentReport', 'incidentReport')->name('display.incident.report');
            Route::get('/hotlineNumber', 'hotlineNumber')->name('hotline.number');
            Route::get('/about', 'about')->name('about');
        });

        Route::prefix('incidentReport')->name('report.')->controller(IncidentReportController::class)->group(function () {
            Route::get('/displayPendingIndcidentReport', 'displayPendingIncidentReport')->name('pending');
            Route::get('/displayIncidentReport', 'displayIncidentReport')->name('accident');
            Route::post('/approveIncidentReport/{reportId}', 'approveIncidentReport')->name('approve');
            Route::delete('/declineIncidentReport/{reportId}', 'declineIncidentReport')->name('decline');
            Route::patch('/removeIncidentReport/{reportId}', 'removeIncidentReport')->name('remove');
        });
    });

    Route::prefix('eligtasGuideline')->controller(GuidelineController::class)->group(function () {
        Route::name('guideline.')->group(function () {
            Route::get('/', 'eligtasGuideline')->name('display');
            Route::post('/guideline/addGuideline', 'createGuideline')->name('create');
            Route::put('/guideline/updateGuideline/{guidelineId}', 'updateGuideline')->name('update');
            Route::patch('/guideline/removeGuideline/{guidelineId}', 'removeGuideline')->name('remove');
        });

        Route::name('guide.')->group(function () {
            Route::get('/guide/{guidelineId}', 'guide')->name('display');
            Route::post('/guide/addGuide{guidelineId}', 'createGuide')->name('create');
            Route::put('/guide/updateGuide/{guideId}', 'updateGuide')->name('update');
            Route::patch('/guide/removeGuide/{guideId}', 'removeGuide')->name('remove');
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
