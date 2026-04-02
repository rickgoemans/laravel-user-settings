<?php

namespace Rickgoemans\LaravelUserSettings\Models\Scopes;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UserSettingUserScope implements Scope
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = Auth::user();

        if (! $user instanceof Model) {
            return;
        }

        $builder->where('user_id', $user->getKey());
    }
}
