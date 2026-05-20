<?php

namespace LaravelSupportCenter;

use Illuminate\Support\Facades\Blade;
use LaravelSupportCenter\Livewire\AdminPage\BaseSupportAdminPage;
use LaravelSupportCenter\Livewire\AdminPage\Tickets\Index as TicketsIndex;
use LaravelSupportCenter\Livewire\AdminPage\Categories\Index as CategoriesIndex;
use LaravelSupportCenter\Livewire\AdminPage\Tags\Index as TagsIndex;
use LaravelSupportCenter\Livewire\UserPage\BaseSupportThreadPage;
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

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-support-center');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishEmailTemplates();

        $this->publishConfig();
        $this->publishViews();
        $this->publishMigrations();

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
        Livewire::component('laravel-support-center.livewire.user-page-thread', BaseSupportThreadPage::class);
    }

    private function publishEmailTemplates(): void
    {
        /** Messages Confirmation */
        $this->publishes([
            __DIR__ . '../resources/views/emails/user/message-received-confirmation.blade.php' =>
                app_path('../resources/emails/Vendor/user/message-received-confirmation.blade.php'),
        ], 'support-center-emails-user-confirmation-message-view');

        $this->publishes([
            __DIR__ . '../resources/views/emails/admin/message-received-confirmation.blade.php' =>
                app_path('../resources/emails/Vendor/admin/message-received-confirmation.blade.php'),
        ], 'support-center-emails-admin-confirmation-message-view');
    }

    protected function publishConfig(): void
    {
        $this->publishes([__DIR__ . '/../config/support-center.php' => config_path('support-center.php')], 'laravel-support-center-config');
    }

    protected function publishViews(): void
    {
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/support-center'),
        ], 'laravel-support-center-views');
    }

    protected function publishMigrations(): void
    {
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'laravel-support-center-migrations');
    }
}
