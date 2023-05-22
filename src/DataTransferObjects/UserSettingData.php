<?php

namespace Rickgoemans\LaravelUserSettings\DataTransferObjects;

use Rickgoemans\LaravelUserSettings\Enums\UserSettingType;
use Spatie\LaravelData\Data;

class UserSettingData extends Data
{
    public function __construct(
        public string          $group,
        public string          $key,
        public UserSettingType $type,
        public mixed           $default = null,
        public mixed           $setting = null,
        public ?int            $user_id = null,
        public ?Carbon         $created_at = null,
        public ?Carbon         $updated_at = null,
    )
    {

    }
}
