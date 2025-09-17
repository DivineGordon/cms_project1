<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // Admin dashboard
    Route::get('admin', function () {
        return inertia('Admin/Dashboard');
    })->name('admin.dashboard');
    
    // Client management
    Route::resource('admin/clients', ClientController::class)->names([
        'index' => 'clients.index',
        'create' => 'clients.create',
        'store' => 'clients.store',
        'show' => 'clients.show',
        'edit' => 'clients.edit',
        'update' => 'clients.update',
        'destroy' => 'clients.destroy',
    ]);
});
