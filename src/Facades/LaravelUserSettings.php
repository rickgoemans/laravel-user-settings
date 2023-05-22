<?php

namespace Rickgoemans\LaravelUserSettings\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rickgoemans\LaravelUserSettings\LaravelUserSettings
 */
class LaravelUserSettings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Rickgoemans\LaravelUserSettings\LaravelUserSettings::class;
    }
}
