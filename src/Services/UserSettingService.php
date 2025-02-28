<?php

namespace Rickgoemans\LaravelUserSettings\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Rickgoemans\LaravelUserSettings\Collections\UserSettingCollection;
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
            ->first(fn (UserSettingData $data): bool => $data->group === $group
                && $data->key === $key);
    }

    public function set(string $group, string $key, mixed $payload): ?UserSetting
    {
        $setting = $this->get($group, $key);

        if (! $setting) {
            return null;
        }

        /** @var UserSetting $userSetting */
        $userSetting = UserSetting::updateOrCreate([
            'group' => $group,
            'key' => $key,
        ], [
            ...$setting->except('created_at', 'updated_at')->all(),
            'value' => $payload,
        ]);

        return $userSetting;
    }

    public function migrate(): void
    {
        $user = Auth::user();

        if (! $user instanceof Model) {
            return;
        }

        Cache::remember("user-settings.{$user->getKey()}", 60 * 60, function () use ($user) {
            /** @var UserSettingCollection $userSettings */
            $userSettings = UserSetting::query()
                ->forUser($user->getKey())
                ->get();

            $this->registeredSettings
                ->each(function (UserSettingData $data) use ($userSettings) {
                    $dbSetting = $userSettings->first(fn (UserSetting $setting): bool => $setting->group === $data->group && $setting->key === $data->key); /** @phpstan-ignore-line */
                    if (! $dbSetting) {
                        $userSetting = new UserSetting;
                        $userSetting->fill($data->except('id', 'defaultValue', 'created_at', 'updated_at')->all());
                        $userSetting->save();
                    }
                });
        });
    }
}
