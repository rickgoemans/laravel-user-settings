<?php

namespace Rickgoemans\LaravelUserSettings\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Rickgoemans\LaravelUserSettings\Enums\UserSettingType;
use Rickgoemans\LaravelUserSettings\Services\UserSettingService;

class DynamicSettingValueCaster implements CastsAttributes
{
    protected UserSettingService $userSettingService;

    public function __construct()
    {
        $this->userSettingService = app(UserSettingService::class);
    }

    /** {@inheritdoc} */
    public function get($model, string $key, $value, array $attributes)
    {
        $key = $attributes['key'];
        $setting = $this->userSettingService->get($attributes['group'], $key);

        if ($setting) {
            $value = match ($setting->type) {
                UserSettingType::Array   => json_decode($value, true),
                UserSettingType::Boolean => !!$value,
                UserSettingType::Date    => Carbon::parse($value),
                UserSettingType::Text    => $value
            };
        }

        return !is_null($value)
            ? $value
            : $setting->default;
    }

    /** {@inheritdoc} */
    public function set($model, string $key, $value, array $attributes)
    {
        $key = $attributes['key'];
        $setting = $this->userSettingService->get($attributes['group'], $key);

        return match ($setting->type) {
            UserSettingType::Array   => json_encode($value),
            UserSettingType::Boolean => !!$value,
            UserSettingType::Date    => Carbon::parse($value),
            UserSettingType::Text    => $value
        };
    }
}