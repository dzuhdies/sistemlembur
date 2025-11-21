<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\ManagerController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/overtimes', [StaffController::class, 'index'])
            ->name('overtimes.index');
    });

Route::middleware(['auth', 'role:leader'])
    ->prefix('leader')
    ->name('leader.')
    ->group(function () {
        Route::get('/overtimes', [LeaderController::class, 'index'])
            ->name('overtimes.index');
        Route::get('/overtimes/create', [LeaderController::class, 'create'])
            ->name('overtimes.create');
        Route::post('/overtimes', [LeaderController::class, 'store'])
            ->name('overtimes.store');
    });

Route::middleware(['auth', 'role:manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::get('/overtimes', [ManagerController::class, 'index'])
            ->name('overtimes.index');
        Route::post('/overtimes/{overtime}/status', [ManagerController::class, 'updateStatus'])
            ->name('overtimes.updateStatus');
        Route::get('/report', [ManagerController::class, 'report'])
            ->name('overtimes.report');
        Route::get('/users/create', [ManagerController::class, 'create'])
            ->name('users.create');
        Route::post('/users', [ManagerController::class, 'store'])
            ->name('users.store');
    });
