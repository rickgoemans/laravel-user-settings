<?php

namespace Rickgoemans\LaravelUserSettings\DataTransferObjects;

use Carbon\Carbon;
use Rickgoemans\LaravelUserSettings\Enums\UserSettingType;
use Spatie\LaravelData\Data;

class UserSettingData extends Data
{
    public function __construct(
        public UserSettingType $type,
        public string $group,
        public string $key,
        public ?int $user_id = null,
        public mixed $value = null,
        public mixed $defaultValue = null,
        public ?Carbon $created_at = null,
        public ?Carbon $updated_at = null,
    ) {

    }
}
