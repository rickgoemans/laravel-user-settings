<?php

namespace Rickgoemans\LaravelUserSettings;

use Rickgoemans\LaravelUserSettings\Commands\LaravelUserSettingsCommand;
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
            ->hasConfigFile()
            ->hasMigration('create_user_settings_table')
            ->hasCommand(LaravelUserSettingsCommand::class);
    }

    public function registeringPackage(): void
    {
        parent::registeringPackage();

        app()->singleton(UserSettingService::class, UserSettingService::class);
    }
}
