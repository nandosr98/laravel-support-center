<?php

namespace LaravelSupportCenter;

use Illuminate\Support\Facades\Blade;
use LaravelSupportCenter\Livewire\AdminPage\BaseSupportAdminPage;
use LaravelSupportCenter\Livewire\AdminPage\Tickets\Index as TicketsIndex;
use LaravelSupportCenter\Livewire\AdminPage\Categories\Index as CategoriesIndex;
use LaravelSupportCenter\Livewire\AdminPage\Tags\Index as TagsIndex;
use LaravelSupportCenter\Livewire\AdminPage\Agents\Index as AgentsIndex;
use LaravelSupportCenter\Livewire\UserPage\BaseSupportUserPage;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelSupportCenterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-support-center')
            ->hasConfigFile()
            ->hasViews('laravel-support-center')
            ->hasMigration('create_support_tables');
    }

    public function boot(): void
    {
        parent::boot();

        $this->publishes([
            __DIR__ . '/Http/Controllers/SupportController.php' =>
                app_path('Http/Controllers/Vendor/SupportController.php'),
        ], 'support-center-user-controller');

        $this->registerLivewireComponents();
        $this->registerBladeComponents();
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    private function registerBladeComponents(): void
    {
        Blade::componentNamespace('LaravelSupportCenter\\View\\Components', 'support');

    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('laravel-support-center.livewire.user-page', BaseSupportUserPage::class);
        Livewire::component('laravel-support-center.livewire.admin-page', BaseSupportAdminPage::class);
        Livewire::component('laravel-support-center.livewire.tickets.index', TicketsIndex::class);
        Livewire::component('laravel-support-center.livewire.categories.index', CategoriesIndex::class);
        Livewire::component('laravel-support-center.livewire.tags.index', TagsIndex::class);
        Livewire::component('laravel-support-center.livewire.agents.index', AgentsIndex::class);
    }
}
