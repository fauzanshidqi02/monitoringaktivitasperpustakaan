<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ActivityCategoryController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [GoogleAuthController::class, 'showLogin'])->name('login');

    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle'])
        ->name('google.redirect');

    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])
        ->name('google.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [GoogleAuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::resource('users', UserController::class);
     Route::resource('modules', ModuleController::class);
     Route::resource('activity-categories', ActivityCategoryController::class);
});

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('roles', RoleController::class);
});

