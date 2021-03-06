<?php

namespace App\Console;

use App\Console\Commands\ClipStore;
use App\Console\Commands\ClipUpdate;
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
        $schedule->command(ClipStore::class)
            ->everyTenMinutes()
            ->between('17:00', '01:00');

        $schedule->command(ClipStore::class)
            ->hourly()
            ->between('2:00', '16:00');

        $schedule->command(ClipUpdate::class)->dailyAt('02:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
