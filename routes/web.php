<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])
    ->group(function () {
        Route::get(config('support-center.route-name'), \LaravelSupportCenter\Livewire\UserPage\BaseSupportUserPage::class)->name('support.user-page');
    });
