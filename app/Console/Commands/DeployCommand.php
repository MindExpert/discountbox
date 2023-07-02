<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class DeployCommand extends Command
{
    protected $signature = 'app:deploy';

    protected $description = 'Deploy application';

    public function handle(): int
    {
        $this->call('optimize:clear');
        //$this->call('settings:clear-cache');

        if (config('debugbar.enabled')) {
            $this->call('debugbar:clear');
        }

        if (App::environment('staging', 'production')) {
            $this->call('optimize');
        }

        $this->info('Done!');

        return self::SUCCESS;
    }
}
