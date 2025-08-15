<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule; // Handles task scheduling in Laravel
use Illuminate\Foundation\Console\Kernel as ConsoleKernel; // Base Laravel console kernel

class Kernel extends ConsoleKernel
{
    /**
     * ====== Schedule commands ======
     * Define the application's scheduled tasks (cron jobs).
     *
     * @param Schedule $schedule
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the custom Foxhole update command to run every minute
        // This will call the command defined in app/Console/Commands/FoxholeUpdate.php
        $schedule->command('foxhole:update')->everyMinute();
    }

    /**
     * ====== Register commands ======
     * Load and register all Artisan commands.
     */
    protected function commands(): void
    {
        // Automatically load all commands from app/Console/Commands directory
        $this->load(__DIR__.'/Commands');

        // Include additional command definitions from routes/console.php
        require base_path('routes/console.php');
    }
}
