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
            ->hasViews()
            ->hasMigration('create_support_tables');
    }

    public function boot()
    {
        $this->loadRoutesFrom('/routes/web.php');
    }
}
