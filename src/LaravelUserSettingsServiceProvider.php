<?php

namespace Rickgoemans\LaravelUserSettings;

use Illuminate\Contracts\Foundation\Application;
use Rickgoemans\LaravelUserSettings\Services\UserSettingService;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelUserSettingsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-user-settings')
            ->hasConfigFile('user-settings')
            ->hasMigration('create_user_settings_table');
    }

    public function registeringPackage(): void
    {
        parent::registeringPackage();

        $this->app->singleton(UserSettingService::class, fn (Application $app): UserSettingService => new UserSettingService);
    }
}
