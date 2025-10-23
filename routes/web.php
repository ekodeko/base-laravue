<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
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
require __DIR__.'/contacts.php';

Route::prefix('master')->name('master.')->group(function () {
    Route::resource('categories', CategoryController::class)->names('categories');
    Route::resource('accounts', AccountController::class);
    Route::resource('transactions', TransactionController::class);
})->middleware(['auth', 'verified']);