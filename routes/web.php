<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/client.php';
require __DIR__.'/admin.php';

// Public page routes
Route::get('page/{client}/{page}', [App\Http\Controllers\PublicPageController::class, 'show'])
    ->name('page.show');
