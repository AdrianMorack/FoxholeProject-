<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule; // Handles task scheduling in Laravel
use Illuminate\Foundation\Console\Kernel as ConsoleKernel; // Base Laravel console kernel

class Kernel extends ConsoleKernel
{
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
