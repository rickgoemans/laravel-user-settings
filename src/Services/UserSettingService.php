<?php

namespace Rickgoemans\LaravelUserSettings\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Rickgoemans\LaravelUserSettings\DataTransferObjects\UserSettingData;
use Rickgoemans\LaravelUserSettings\Models\UserSetting;

class UserSettingService
{
    /** @var Collection<int, UserSettingData> */
    protected Collection $registeredSettings;

    public function __construct()
    {
        $this->registeredSettings = collect();
    }

    public function register(UserSettingData $data): static
    {
        $this->registeredSettings->push($data);

        return $this;
    }

    public function all(): Collection
    {
        return $this->registeredSettings;
    }

    public function get(string $group, string $key): ?UserSettingData
    {
        return $this->registeredSettings
            ->first(fn (UserSettingData $data) => $data->group === $group
                && $data->key === $key);
    }

    public function set(string $group, string $key, mixed $payload): ?UserSetting
    {
        $setting = $this->get($group, $key);

        if (! $setting) {
            return null;
        }

        return UserSetting::updateOrCreate([
            'group' => $group,
            'key' => $key,
        ], [
            ...$setting->except('created_at', 'updated_at')->all(),
            'value' => $payload,
        ]);
    }

    public function migrate(): void
    {
        $user = Auth::user();

        if (! $user instanceof Model) {
            return;
        }

        Cache::remember("user-settings.{$user->getKey()}", 60 * 60, function () use ($user) {
            $userSettings = UserSetting::query()
                ->forUser($user->getKey())
                ->get();

            $this->registeredSettings
                ->each(function (UserSettingData $data) use ($userSettings) {
                    $dbSetting = $userSettings->first(fn (UserSetting $setting) => $setting->group == $data->group
                        && $setting->key == $data->key);

                    if (! $dbSetting) {
                        UserSetting::create($data->except('defaultValue', 'created_at', 'updated_at')->all());
                    }
                });
        });
    }
}
