<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicApplicationController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\JobOpeningController;
use App\Http\Controllers\RecruitmentSettingController;
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
    Route::resource('job-openings', JobOpeningController::class);
    
    Route::get('/settings', [RecruitmentSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [RecruitmentSettingController::class, 'update'])->name('settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
