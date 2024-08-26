<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\GatewayDataController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ModuledataController;

Route::get('/module-data', [ModuledataController::class, 'getDataForAnalysis']);



// Route to fetch notifications for specific regions and date range
Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.fetch');


Route::get('/regions/{superuserId}', [RegionController::class, 'getRegionsBySuperuser'])->name('regions.bySuperuser');

Route::get('/gateway-data', [GatewayDataController::class, 'getGatewayData']);


Route::get('/regions', [RegionController::class, 'getRegions'])->name('regions.data');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Registration Routes
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// Approval Required Route
Route::get('/approval-required', [RegisteredUserController::class, 'approvalRequired'])
    ->name('approval.required');

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::post('/admin/approve/{id}', [AdminController::class, 'approve']);
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Authentication Routes
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login']);
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Dashboard Routes (Only accessible to authenticated admins)
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::get('/admin/edit-regions/{id}', [AdminController::class, 'editRegions'])->name('admin.editRegions');
    Route::post('/admin/update-regions/{id}', [AdminController::class, 'updateRegions'])->name('admin.updateRegions');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    Route::get('/admin/create-admin', [AdminController::class, 'createAdmin'])->name('admin.createAdmin');
    Route::post('/admin/store-admin', [AdminController::class, 'storeAdmin'])->name('admin.storeAdmin');
});

require __DIR__.'/auth.php';
