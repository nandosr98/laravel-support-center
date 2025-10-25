<?php

use Illuminate\Support\Facades\Route;
use LaravelSupportCenter\Http\Controllers\UserSupportController;

Route::get(config('support-center.route-name'), \LaravelSupportCenter\Livewire\UserPage\Index::class)->name('support.user-page');

//Route::middleware(['web', 'auth'])->prefix('support')->name('support.')->group(function () {
//        Route::get('/', [SupportController::class, 'index'])->name('index');
//        Route::post('/', [SupportController::class, 'store'])->name('store');
//    });
