<?php

use Illuminate\Support\Facades\Route;
use LaravelSupportCenter\Http\Controllers\SupportController;

Route::get('/'. config('support-center.route-name'), [SupportController::class, 'support'])->name('support');

Route::middleware(['web', 'auth'])->prefix('support')->name('support.')->group(function () {
        Route::get('/', [SupportController::class, 'index'])->name('index');
        Route::post('/', [SupportController::class, 'store'])->name('store');
    });
