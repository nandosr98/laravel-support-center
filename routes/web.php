<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])
    ->group(function () {
        Route::get(config('support-center.route.prefix'), \LaravelSupportCenter\Livewire\UserPage\BaseSupportUserPage::class)->name(config('support-center.route.name'));
    });

Route::middleware(['web', 'auth', 'admin'])->prefix('/admin/support')->group(function () {
    Route::get('/', \LaravelSupportCenter\Livewire\AdminPage\BaseSupportAdminPage::class)->name('support.admin-page');

    Route::prefix('tickets')->group(function () {
        Route::get('/', \LaravelSupportCenter\Livewire\AdminPage\Tickets\Index::class)->name('support.admin-page.tickets');
        Route::get('/{ticket}', \LaravelSupportCenter\Livewire\AdminPage\Tickets\ViewTicket::class)->name('support.admin-page.tickets.view');
    });

    Route::prefix('categories')->group(function () {
       Route::get('/', \LaravelSupportCenter\Livewire\AdminPage\Categories\Index::class)->name('support.admin-page.categories');
    });

    Route::prefix('tags')->group(function () {
        Route::get('/', \LaravelSupportCenter\Livewire\AdminPage\Tags\Index::class)->name('support.admin-page.tags');
    });
});
