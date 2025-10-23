<?php

namespace LaravelSupportCenter\LaravelSupportCenter;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use LaravelSupportCenter\LaravelSupportCenter\Commands\LaravelSupportCenterCommand;

class LaravelSupportCenterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-support-center')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_support_center_table')
            ->hasCommand(LaravelSupportCenterCommand::class);
    }
}
