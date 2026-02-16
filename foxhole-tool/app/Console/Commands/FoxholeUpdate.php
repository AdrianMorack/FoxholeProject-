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
     * Example: php artisan foxhole:update --shard=able
     * Example: php artisan foxhole:update --all
     */
    protected $signature = 'foxhole:update {--shard= : Specific shard to update (able/baker)} {--all : Update all shards}';

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
        $shards = ['able', 'baker'];
        
        // Check if user wants all shards or specific shard
        if ($this->option('all')) {
            $this->info('Syncing all shards...');
            $shardsToSync = $shards;
        } elseif ($shard = $this->option('shard')) {
            if (!in_array($shard, $shards)) {
                $this->error("Invalid shard: {$shard}. Must be 'able' or 'baker'.");
                return self::FAILURE;
            }
            $shardsToSync = [$shard];
        } else {
            // Default: sync both shards
            $shardsToSync = $shards;
        }
        
        // Sync each shard
        foreach ($shardsToSync as $shard) {
            $this->info("Syncing shard: {$shard}");
            
            // Temporarily set session shard for the sync
            session(['foxhole_shard' => $shard]);
            
            // Call the service that fetches data from the Foxhole API
            // and updates/inserts it into the database
            $sync->run();
            
            $this->info("✓ Shard {$shard} synced successfully\n");
        }

        // Print a message in the console so we know all syncs completed
        $this->info('All Foxhole data synced');

        // Return a success code for Artisan
        return self::SUCCESS;
    }
}
