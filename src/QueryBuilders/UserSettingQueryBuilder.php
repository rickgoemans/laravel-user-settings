<?php

namespace Rickgoemans\LaravelUserSettings\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class UserSettingQueryBuilder extends Builder
{
    public function forUser(int $userId): static
    {
        return $this->where('user_id', $userId);
    }
}
