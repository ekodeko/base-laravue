<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('master')->group(function () {
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'master.categories.index',
        'create' => 'master.categories.create',
        'store' => 'master.categories.store',
        'edit' => 'master.categories.edit',
        'update' => 'master.categories.update',
        'destroy' => 'master.categories.destroy',
    ]);
});
