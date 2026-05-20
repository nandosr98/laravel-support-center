<?php

use Illuminate\Support\Facades\Route;
use LaravelSupportCenter\Livewire\UserPage\BaseSupportThreadPage;
use LaravelSupportCenter\Livewire\UserPage\BaseSupportUserPage;

Route::middleware(['web'])
    ->group(function () {
        Route::get(config('support-center.route.prefix'), BaseSupportUserPage::class)->name(config('support-center.route.name'));

        Route::get(config('support-center.route.prefix'). '/{uuid}', BaseSupportThreadPage::class)->name(config('support-center.thread-route.name'));
    });
