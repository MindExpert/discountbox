<?php

namespace App\Console;

use App\Console\Commands\AppFreshCommand;
use App\Console\Commands\CheckDiscountBoxExpirationDateCommand;
use App\Console\Commands\DeployCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        AppFreshCommand::class,
        DeployCommand::class,
        CheckDiscountBoxExpirationDateCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
         $schedule->command('app:check-discount-box-expiration-date-command')
            ->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
