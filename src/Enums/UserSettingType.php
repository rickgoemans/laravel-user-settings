<?php

namespace Rickgoemans\LaravelUserSettings\Enums;

enum UserSettingType: string
{
    case Text = 'text';
    case Boolean = 'boolean';
    case Date = 'date';
    case Array = 'array';
}
