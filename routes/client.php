<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Auth\ClientAuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Client Authentication Routes
Route::middleware('guest:client')->group(function () {
    Route::get('client/login', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
    Route::post('client/login', [ClientAuthController::class, 'login']);
    Route::get('client/register', [ClientAuthController::class, 'showRegistrationForm'])->name('client.register');
    Route::post('client/register', [ClientAuthController::class, 'register']);
});

Route::middleware(['client.auth'])->group(function () {
    Route::post('client/logout', [ClientAuthController::class, 'logout'])->name('client.logout');
    
    // Client Dashboard
    Route::get('client/dashboard', function () {
        return inertia('Client/Dashboard');
    })->name('client.dashboard');
    
    // Pages Management
    Route::resource('client/pages', PageController::class)->names([
        'index' => 'pages.index',
        'create' => 'pages.create',
        'store' => 'pages.store',
        'show' => 'pages.show',
        'edit' => 'pages.edit',
        'update' => 'pages.update',
        'destroy' => 'pages.destroy',
    ]);
    
    Route::patch('client/pages/{page}/toggle-publish', [PageController::class, 'togglePublish'])->name('pages.toggle-publish');
    
    // Analytics
    Route::get('client/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('client/analytics/export', [AnalyticsController::class, 'export'])->name('analytics.export');
});
