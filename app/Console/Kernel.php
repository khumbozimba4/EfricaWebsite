<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        \App\Console\Commands\GenerateApiRoutes::class,
        \App\Console\Commands\GenerateSearchableModels::class,
        \App\Console\Commands\GenerateAPIResourse::class,
        \App\Console\Commands\GenerateAPIResourseUpdates::class,
        \App\Console\Commands\GenerateAPIVirtualModels::class,
         \App\Console\Commands\FunctionAppender::class,
         \App\Console\Commands\SendDailyReportEmail::class,

    ];
    

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
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
