<?php

namespace App\Console;

use App\Console\Commandes\Clips;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(Clips\Store::class)
            ->everyTenMinutes()
            ->between('17:00', '01:00');

        $schedule->command(Clips\Store::class)
            ->hourly()
            ->between('2:00', '16:00');

        $schedule->command(Clips\UpdateRecentSuspect::class)->everyTenMinutes();

        $schedule->command(Clips\Update::class)->dailyAt('02:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
