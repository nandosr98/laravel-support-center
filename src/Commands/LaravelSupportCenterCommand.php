<?php

namespace LaravelSupportCenter\Commands;

use Illuminate\Console\Command;

class LaravelSupportCenterCommand extends Command
{
    public $signature = 'laravel-support-center';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
