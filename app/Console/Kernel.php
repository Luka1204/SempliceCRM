<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Send activity reminders every hour for activities in the next 24 hours
        $schedule->command('crm:send-activity-reminders --hours=24')
                 ->hourly()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/activity-reminders.log'));

        // Send urgent reminders for activities in the next 1 hour
        $schedule->command('crm:send-activity-reminders --hours=1')
                 ->everyMinute()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/urgent-reminders.log'));

        // Daily summary at 8 AM
        $schedule->command('crm:send-activity-reminders --hours=24 --summary')
                 ->dailyAt('08:00')
                 ->appendOutputTo(storage_path('logs/daily-summary.log'));
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}