<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommunityUserController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::user()->role === 'community_user') {
            return redirect()->route('user.dashboard');
        }

        Auth::logout();
    }

    return redirect()->route('login');
});
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'register'])
        ->middleware('throttle:3,1')
        ->name('register.submit');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Administrator Routes
    |--------------------------------------------------------------------------
    | Only users with the admin role can access these routes.
    */

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminController::class, 'dashboard'])
                ->name('dashboard');

            // Water Sources
            Route::get('/water-sources', [AdminController::class, 'waterSources'])
                ->name('water-sources');

            Route::post('/water-sources', [AdminController::class, 'storeWaterSource'])
                ->name('water-sources.store');

            Route::put('/water-sources/{waterSource}', [AdminController::class, 'updateWaterSource'])
                ->whereNumber('waterSource')
                ->name('water-sources.update');

            Route::delete('/water-sources/{waterSource}', [AdminController::class, 'deleteWaterSource'])
                ->whereNumber('waterSource')
                ->name('water-sources.destroy');

            // Access Requests
            Route::get('/access-requests', [AdminController::class, 'accessRequests'])
                ->name('access-requests');

            Route::post('/access-requests/{accessRequest}/status', [AdminController::class, 'updateAccessRequestStatus'])
                ->whereNumber('accessRequest')
                ->name('access-requests.update-status');

            Route::get('/request-approvals', [AdminController::class, 'requestApprovals'])
                ->name('request-approvals');

            // Schedule Management
            Route::get('/schedule-management', [AdminController::class, 'scheduleManagement'])
                ->name('schedule-management');

            Route::post('/schedule-management/{accessRequest}', [AdminController::class, 'saveSchedule'])
                ->whereNumber('accessRequest')
                ->name('schedule.store');

            Route::delete('/schedule-management/{accessRequest}', [AdminController::class, 'deleteSchedule'])
                ->whereNumber('accessRequest')
                ->name('schedule.destroy');

            // Access Records
            Route::get('/access-records', [AdminController::class, 'accessRecords'])
                ->name('access-records');

            // User Management
            Route::get('/user-management', [AdminController::class, 'userManagement'])
                ->name('user-management');

            Route::post('/user-management', [AdminController::class, 'storeManagedUser'])
                ->middleware('throttle:5,1')
                ->name('user-management.store');

            Route::put('/user-management/{managedUser}', [AdminController::class, 'updateManagedUser'])
                ->whereNumber('managedUser')
                ->name('user-management.update');

            // Reports
            Route::get('/reports', [AdminController::class, 'reports'])
                ->name('reports');

            Route::get('/reports/export/pdf', [AdminController::class, 'exportReportsPdf'])
                ->name('reports.pdf');

            Route::get('/reports/export/excel', [AdminController::class, 'exportReportsExcel'])
                ->name('reports.excel');
        });

    /*
    |--------------------------------------------------------------------------
    | Community User Routes
    |--------------------------------------------------------------------------
    | Only users with the community_user role can access these routes.
    */

    Route::middleware('role:community_user')
        ->prefix('user')
        ->name('user.')
        ->group(function () {

            Route::get('/dashboard', [CommunityUserController::class, 'dashboard'])
                ->name('dashboard');

            Route::get('/water-sources', [CommunityUserController::class, 'waterSources'])
                ->name('water-sources');

            Route::get('/check-availability', [CommunityUserController::class, 'checkAvailability'])
                ->name('check-availability');

            Route::get('/request-access', [CommunityUserController::class, 'createRequest'])
                ->name('request-access');

            Route::post('/request-access', [CommunityUserController::class, 'storeWaterAccess'])
                ->middleware('throttle:5,1')
                ->name('request-access.store');

            Route::get('/my-requests', [CommunityUserController::class, 'myRequests'])
                ->name('my-requests');

            Route::get('/my-schedule', [CommunityUserController::class, 'mySchedule'])
                ->name('my-schedule');

            Route::get('/access-history', [CommunityUserController::class, 'accessHistory'])
                ->name('access-history');
        });

});
