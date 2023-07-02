<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;

class AppFreshCommand extends Command
{
    protected $signature = 'app:fresh {--force}';

    protected $description = 'Create a fresh state of application';

    public function handle(): int
    {
        if (App::environment('production')) {
            $this->error("This command should not be executed on production environment!");

            return self::FAILURE;
        }

        if (App::environment('local') && config('queue.default') === 'redis') {
            Redis::command('flushdb');
        }

        $this->call('app:deploy');

        if ($this->option('force') || $this->confirm('Are you sure that you want Drop all the Database? All DATA will be lost?')) {
            $this->warn('Start fresh migration of DB....');

            $this->call('db:wipe', ['--database' => 'mysql', '--drop-views' => true]);
            $this->call('migrate:fresh', ['--seed' => true]);

            $this->warn('Database Migration COMPLETED!');

            return self::SUCCESS;
        }

        $this->warn('Fresh Migration was aborted....');
        return self::FAILURE;
    }
}
