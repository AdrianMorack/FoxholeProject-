<?php

namespace App\Console\Commands;

use Illuminate\Console\Command; // Base class for all Artisan commands
use App\Services\FoxholeSyncService; // Service class that handles API fetching and database updates

class FoxholeUpdate extends Command
{
    /**
     * ====== Command signature ======
     * This is how you call the command via Artisan CLI.
     * Example: php artisan foxhole:update
     */
    protected $signature = 'foxhole:update';

    /**
     * ====== Command description ======
     * Short description displayed when listing commands with `php artisan list`
     */
    protected $description = 'Fetch Foxhole API and cache into MySQL';

    /**
     * ====== Handle execution ======
     * This method runs when the command is executed.
     *
     * @param FoxholeSyncService $sync - The service injected by Laravel's container
     * @return int
     */
    public function handle(FoxholeSyncService $sync)
    {
        // Call the service that fetches data from the Foxhole API
        // and updates/inserts it into the database
        $sync->run();

        // Print a message in the console so we know the sync completed
        $this->info('Foxhole data synced');

        // Return a success code for Artisan
        return self::SUCCESS;
    }
}
