<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])
    ->group(function () {
        Route::get(config('support-center.route-name'), \LaravelSupportCenter\Livewire\UserPage\BaseSupportUserPage::class)->name('support.user-page');

    });

Route::middleware(['web'])->prefix('/admin/support')->group(function () {
    Route::get('/', \LaravelSupportCenter\Livewire\AdminPage\BaseSupportAdminPage::class)->name('support.admin-page');

    Route::prefix('tickets')->group(function () {
        Route::get('/', \LaravelSupportCenter\Livewire\AdminPage\Tickets\Index::class)->name('support.admin-page.tickets');
    });

    Route::prefix('categories')->group(function () {
       Route::get('/', \LaravelSupportCenter\Livewire\AdminPage\Categories\Index::class)->name('support.admin-page.categories');
    });

    Route::prefix('agents')->group(function () {
        Route::get('/', \LaravelSupportCenter\Livewire\AdminPage\Agents\Index::class)->name('support.admin-page.agents');
    });

    Route::prefix('tags')->group(function () {
        Route::get('/', \LaravelSupportCenter\Livewire\AdminPage\Tags\Index::class)->name('support.admin-page.tags');
    });


});
