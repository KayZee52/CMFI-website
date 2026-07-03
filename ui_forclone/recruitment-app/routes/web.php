<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicApplicationController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\JobOpeningController;
use App\Http\Controllers\RecruitmentSettingController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/apply', [PublicApplicationController::class, 'index'])->name('apply');
Route::post('/apply', [PublicApplicationController::class, 'store'])->name('apply.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

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
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
