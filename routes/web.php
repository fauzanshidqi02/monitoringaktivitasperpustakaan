<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ActivityCategoryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityFileController;
use App\Http\Controllers\ActivityReviewController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [GoogleAuthController::class, 'showLogin'])
        ->name('login');

    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle'])
        ->name('google.redirect');

    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])
        ->name('google.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Laporan Aktivitas
    |--------------------------------------------------------------------------
    */
    Route::get('/reports/activities', [ReportController::class, 'activities'])
        ->name('reports.activities');

    Route::get('/reports/activities/export', [ReportController::class, 'exportActivities'])
        ->name('reports.activities.export');

    Route::get('/reports/activities/export-pdf', [ReportController::class, 'exportActivitiesPdf'])
        ->name('reports.activities.export-pdf');

    /*
    |--------------------------------------------------------------------------
    | Review Aktivitas
    |--------------------------------------------------------------------------
    | Hanya role tertentu yang boleh review.
    */
    Route::middleware(['role:super_admin,admin,kepala_perpustakaan,koordinator'])->group(function () {
        Route::get('/activities/{activity}/review', [ActivityReviewController::class, 'edit'])
            ->name('activities.review.edit');

        Route::put('/activities/{activity}/review', [ActivityReviewController::class, 'update'])
            ->name('activities.review.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Aktivitas
    |--------------------------------------------------------------------------
    */
    Route::resource('activities', ActivityController::class);

    /*
    |--------------------------------------------------------------------------
    | Upload Bukti Aktivitas
    |--------------------------------------------------------------------------
    */
    Route::post('/activities/{activity}/files', [ActivityFileController::class, 'store'])
        ->name('activities.files.store');

    Route::delete('/activity-files/{activityFile}', [ActivityFileController::class, 'destroy'])
        ->name('activity-files.destroy');

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [GoogleAuthController::class, 'logout'])
        ->name('logout');
});

/*
|--------------------------------------------------------------------------
| Master Data
|--------------------------------------------------------------------------
| Super admin dan admin boleh kelola user, modul, dan jenis aktivitas.
*/
Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('modules', ModuleController::class);
    Route::resource('activity-categories', ActivityCategoryController::class);
});

/*
|--------------------------------------------------------------------------
| Role
|--------------------------------------------------------------------------
| Hanya super admin yang boleh kelola role.
*/
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('roles', RoleController::class);
});
