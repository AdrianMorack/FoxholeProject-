<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{MapIcon, WarState};

class FoxholeCleanup extends Command
{
    protected $signature = 'foxhole:cleanup {--keep-wars=1 : Number of most recent wars to keep}';
    protected $description = 'Clean up old war data from database';

    public function handle()
    {
        $keepWars = (int) $this->option('keep-wars');
        
        foreach (['able', 'baker'] as $shard) {
            $this->info("Cleaning up shard: {$shard}");
            
            // Get the most recent war IDs that actually have MapIcon data
            $warIdsToKeep = MapIcon::where('shard', $shard)
                ->select('war_id')
                ->distinct()
                ->orderBy('updated_at', 'desc')
                ->limit($keepWars)
                ->pluck('war_id')
                ->toArray();
            
            if (empty($warIdsToKeep)) {
                $this->warn("No MapIcon data found for {$shard}");
                continue;
            }
            
            $this->info("Keeping wars with data: " . implode(', ', $warIdsToKeep));
            
            // Delete MapIcons from old wars
            $deleted = MapIcon::where('shard', $shard)
                ->whereNotIn('war_id', $warIdsToKeep)
                ->delete();
            
            $this->info("Deleted {$deleted} map icons from old wars");
            
            // Delete old WarState records (keep a few more for history)
            $warStatesToKeep = WarState::where('shard', $shard)
                ->orderBy('updated_at', 'desc')
                ->limit($keepWars + 2) // Keep 2 extra WarState records
                ->pluck('war_id')
                ->toArray();
            
            $deletedWars = WarState::where('shard', $shard)
                ->whereNotIn('war_id', array_merge($warIdsToKeep, $warStatesToKeep))
                ->delete();
            
            $this->info("Deleted {$deletedWars} old war state records");
        }
        
        $this->info("Cleanup complete!");
        
        return 0;
    }
}
