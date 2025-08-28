<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Tanpa Authentication)
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Public complaints - dapat diakses tanpa login
Route::get('/complaints/public', [ComplaintController::class, 'publicIndex'])->name('complaints.public');

// API untuk filter keluhan (public)
Route::get('/api/complaints/filter', [WelcomeController::class, 'filterComplaints'])->name('complaints.filter');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (Perlu Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // Dashboard/Home - redirect user berdasarkan role
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Complaint Management untuk User
    Route::prefix('complaints')->name('complaints.')->group(function () {
        Route::get('/', [ComplaintController::class, 'index'])->name('index');
        Route::get('/create', [ComplaintController::class, 'create'])->name('create');
        Route::post('/', [ComplaintController::class, 'store'])->name('store');

        // EDIT & UPDATE pakai model binding
        Route::get('/{complaint}/edit', [ComplaintController::class, 'edit'])->name('edit');
        Route::put('/{complaint}', [ComplaintController::class, 'update'])->name('update');
        Route::delete('/{complaint}', [ComplaintController::class, 'destroy'])->name('destroy');
    });

    // Like functionality - perlu login
    Route::post('/complaints/{complaint}/like', [ComplaintController::class, 'like'])->name('complaints.like');
});

/*
|--------------------------------------------------------------------------
| USER ONLY ROUTES (Role: user)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY ROUTES (Role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {
    
    // Admin Dashboard → diarahkan ke controller
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
    
    // Admin Complaint Management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/complaints', [ComplaintController::class, 'adminDashboard'])->name('complaints.dashboard');
        Route::post('/complaints/bulk-update', [ComplaintController::class, 'bulkUpdateStatus'])->name('complaints.bulk-update');
        Route::get('/complaints/export', [ComplaintController::class, 'export'])->name('complaints.export');
        Route::put('/complaints/{complaint}/status', [ComplaintController::class, 'updateStatus'])
        ->name('complaints.updateStatus');
    });
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTE: Complaint detail (taruh paling bawah supaya tidak bentrok)
|--------------------------------------------------------------------------
*/

Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
