<?php

namespace Rickgoemans\LaravelUserSettings\Models;

use Illuminate\Database\Eloquent\Attributes\CollectedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rickgoemans\LaravelUserSettings\Casts\DynamicSettingValueCaster;
use Rickgoemans\LaravelUserSettings\Collections\UserSettingCollection;
use Rickgoemans\LaravelUserSettings\Concerns\ScopesUser;
use Rickgoemans\LaravelUserSettings\Database\Factories\UserSettingFactory;
use Rickgoemans\LaravelUserSettings\DataTransferObjects\UserSettingData;
use Rickgoemans\LaravelUserSettings\Enums\UserSettingType;
use Rickgoemans\LaravelUserSettings\Models\Scopes\UserSettingUserScope;
use Rickgoemans\LaravelUserSettings\QueryBuilders\UserSettingQueryBuilder;
use Spatie\LaravelData\WithData;

#[CollectedBy(UserSettingCollection::class)]
#[UseEloquentBuilder(UserSettingQueryBuilder::class)]
#[UseFactory(UserSettingFactory::class)]
#[ScopedBy(UserSettingUserScope::class)]
class UserSetting extends Model
{
    use HasFactory;
    use ScopesUser;

    /** @use WithData<UserSettingData> */
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
        'type' => UserSettingType::class,
        'value' => DynamicSettingValueCaster::class,
    ];

    protected $dataClass = UserSettingData::class;
}
