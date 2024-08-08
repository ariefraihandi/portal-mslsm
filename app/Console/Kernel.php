<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Register your command here if not using automatic discovery
        \App\Console\Commands\ResendNotifications::class,
    ];

    // protected function schedule(Schedule $schedule)
    // {
    //     // Schedule the resend notifications command to run hourly
    //     $schedule->command('notifications:resend')->hourly();
    // }

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('notifications:resend')->everyMinute();
    
        // Example task for verification
        $schedule->call(function () {
            Log::info('Scheduler is running correctly.');
        })->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
