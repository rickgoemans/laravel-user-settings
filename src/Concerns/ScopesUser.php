<?php

namespace Rickgoemans\LaravelUserSettings\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait ScopesUser
{
    public static function bootScopesUser(): void
    {
        $user = Auth::user();

        static::addGlobalScope('scopes-user', function (Builder $query) use ($user) {
            if (! $user instanceof Model) {
                return;
            }

            $query->where('user_id', $user->getKey());
        });

        static::saving(function (Model $model) use ($user) {
            if (! $user instanceof Model) {
                return;
            }

            $model->user_id = $user->getKey();
        });
    }
}
