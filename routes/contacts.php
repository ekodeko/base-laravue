<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('master')->group(function () {
    Route::resource('contacts', ContactController::class)->names([
        'index' => 'master.contacts.index',
        'create' => 'master.contacts.create',
        'store' => 'master.contacts.store',
        'edit' => 'master.contacts.edit',
        'update' => 'master.contacts.update',
        'destroy' => 'master.contacts.destroy',
    ]);
});
