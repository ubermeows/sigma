<?php

namespace App\Console;

use App\Console\Commandes\Clip;
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
        $schedule->command(Clip\Store::class)
            ->everyTenMinutes()
            ->between('17:00', '01:00');

        $schedule->command(Clip\Store::class)
            ->hourly()
            ->between('2:00', '16:00');

        $schedule->command(Clip\Update::class)->dailyAt('02:00');
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
