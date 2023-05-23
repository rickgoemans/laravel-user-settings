<?php

namespace Rickgoemans\LaravelUserSettings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rickgoemans\LaravelUserSettings\Casts\DynamicSettingValueCaster;
use Rickgoemans\LaravelUserSettings\Collections\UserSettingCollection;
use Rickgoemans\LaravelUserSettings\Concerns\ScopesUser;
use Rickgoemans\LaravelUserSettings\Database\Factories\UserSettingFactory;
use Rickgoemans\LaravelUserSettings\DataTransferObjects\UserSettingData;
use Rickgoemans\LaravelUserSettings\Enums\UserSettingType;
use Rickgoemans\LaravelUserSettings\QueryBuilders\UserSettingQueryBuilder;
use Spatie\LaravelData\WithData;

class UserSetting extends Model
{
    use HasFactory;
    use ScopesUser;
    use WithData;

    /** {@inheritdoc} */
    protected $fillable = [
        'user_id',
        'type',
        'group',
        'key',
        'value',
    ];

    /** {@inheritdoc} */
    protected $casts = [
        'type'  => UserSettingType::class,
        'value' => DynamicSettingValueCaster::class,
    ];

    protected $dataClass = UserSettingData::class;

    /**
     * {@inheritdoc}
     */
    public function newEloquentBuilder($query): UserSettingQueryBuilder
    {
        return new UserSettingQueryBuilder($query);
    }

    /**
     * {@inheritdoc}
     */
    public static function newFactory(): UserSettingFactory
    {
        return UserSettingFactory::new();
    }

    /**
     * {@inheritdoc}
     */
    public function newCollection(array $models = []): UserSettingCollection
    {
        return new UserSettingCollection($models);
    }
}
