<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PublicApplicationController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\JobOpeningController;
use App\Http\Controllers\RecruitmentSettingController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('apply');
});

Route::get('/apply', [PublicApplicationController::class, 'index'])->name('apply');
Route::post('/apply', [PublicApplicationController::class, 'store'])->name('apply.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/applicants/pipeline', [ApplicantController::class, 'pipeline'])->name('applicants.pipeline');
    Route::resource('applicants', ApplicantController::class)->only(['index', 'show']);
    Route::post('/applications/{application}/update-stage', [ApplicationController::class, 'updateStage'])->name('applications.update-stage');
    Route::post('/applications/{application}/decision', [ApplicationController::class, 'makeDecision'])->name('applications.decision');
    
    Route::resource('job-openings', JobOpeningController::class);
    Route::resource('interviews', InterviewController::class);
    Route::post('/interviews/{interview}/scorecard', [InterviewController::class, 'submitScorecard'])->name('interviews.scorecard.submit');
    
    Route::get('/settings', [RecruitmentSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [RecruitmentSettingController::class, 'update'])->name('settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['patch', 'put'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

require __DIR__.'/auth.php';
