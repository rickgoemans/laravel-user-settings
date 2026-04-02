<?php

namespace Rickgoemans\LaravelUserSettings\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait ScopesUser
{
    public static function bootScopesUser(): void
    {
        static::saving(function (Model $model): void {
            $user = Auth::user();

            if (! $user instanceof Model) {
                return;
            }

            $model->user_id = $user->getKey(); /** @phpstan-ignore-line */
        });
    }
}
