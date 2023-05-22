<?php

namespace Rickgoemans\LaravelUserSettings\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use OutSmart\Core\Domain\Settings\Enums\UserSettingType;
use Rickgoemans\LaravelUserSettings\Models\UserSetting;

/** @extends Factory<UserSetting> */
class UserSettingFactory extends Factory
{
    protected $model = UserSetting::class;

    /** {@inheritdoc} */
    public function definition(): array
    {
        return [
            'group' => fake()->word,
            'key'   => fake()->word,
            'type'  => fake()->randomElement(UserSettingType::cases()),
            'value' => null,
        ];
    }

    public function forUser(Model $user): self
    {
        return $this->state(function(array $attributes) use ($user): array {
            return [
                'user_id' => $user->getKey(),
            ];
        });
    }
}
