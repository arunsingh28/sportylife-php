<?php

namespace App\Console;

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
    protected $commands = [
        Commands\notificationCron::class,
        Commands\freetrialCron::class,
        Commands\sendWaterIntakeNotification::class,
        Commands\SendTimelyLiveSessionNotification::class,
        Commands\sendTimelyLiveSessionNotificationForAdult::class,
        Commands\sendTimelyLiveSessionNotificationForKid::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sendnotification:cron')->everyMinute();
        $schedule->command('freetrial:cron')->daily();
        $schedule->command('sendWaterIntakeNotification:cron')->everyTwoHours();
        // $schedule->command('sendTimelyLiveSessionNotificationForAdult:cron')->dailyAt('07:00');
        // $schedule->command('sendTimelyLiveSessionNotificationForKid:cron')->dailyAt('17:00');
        // $schedule->command('sendTimelyLiveSessionNotificationForAdult:cron')->everyMinute();
        // $schedule->command('sendTimelyLiveSessionNotificationForKid:cron')->everyMinute();
        // $schedule->command('inspire')->hourly();
        // \Log::info("kernal run");

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
