<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

// Public Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthController::class, 'logout']); // For ease of use in preview/testing

    // Redirect Root to Dashboard
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Dashboard
    Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');

    // Tasks (Chosen Entity CRUD) - Authorization is validated inside controller methods and views
    Route::resource('tasks', TaskController::class);

    // Admin & Management CRUDs (Roles, Permissions, Users)
    Route::middleware('permission:manage roles')->group(function () {
        Route::resource('roles', RoleController::class);
    });

    Route::middleware('permission:manage permissions')->group(function () {
        Route::resource('permissions', PermissionController::class);
    });

    Route::middleware('permission:manage users')->group(function () {
        Route::resource('users', UserController::class);
    });
});
