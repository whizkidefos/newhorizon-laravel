<?php

namespace App\Console\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Run the command every day at midnight
        $schedule->command('documents:check-expiring')->daily();


        // Send shift reminders daily at 6 PM for next day's shifts
        $schedule->job(new SendShiftReminders)->dailyAt('18:00');

    }
}