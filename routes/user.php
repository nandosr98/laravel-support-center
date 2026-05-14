<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])
    ->group(function () {
        Route::get(config('support-center.route.prefix'), \LaravelSupportCenter\Livewire\UserPage\BaseSupportUserPage::class)->name(config('support-center.route.name'));
    });
