<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('home');

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';


Route::prefix('master')->group(function () {
    Route::prefix('category')->group(function () {
        Route::get('/', []);
    });
    Route::resource('accounts', AccountController::class);
})->middleware(['auth', 'verified']);