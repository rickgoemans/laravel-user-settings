<?php

namespace Rickgoemans\LaravelUserSettings\Commands;

use Illuminate\Console\Command;

class LaravelUserSettingsCommand extends Command
{
    public $signature = 'laravel-user-settings';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
