<?php

namespace LaravelSupportCenter;

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

    public function boot()
    {
        parent::boot();
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->publishes([
            __DIR__ . '/Http/Controllers/SupportController.php' =>
                app_path('Http/Controllers/Vendor/SupportController.php'),
        ], 'support-center-user-controller');

    }
}
