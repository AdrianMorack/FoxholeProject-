<?php

namespace App\Services; // service lives here

// Bring in the models we’ll be saving to
use App\Models\{WarState, Map as MapModel, MapReport, MapIcon};
// DB helper for transactions
use Illuminate\Support\Facades\DB;
// Carbon for date/timestamp handling
use Carbon\Carbon;

class FoxholeSyncService
{
    // Inject our API class when service is created
    public function __construct(private FoxholeApi $api) {}

    // Main entry point for running the sync
    public function run(): void
    {
        $shard = $this->api->getShard(); // Get current shard
        $this->info("Starting Foxhole sync for shard: {$shard}..."); // start log

        try {
            $this->syncWar($shard);              // sync war state info first
        } catch (\Exception $e) {
            $this->info("Failed to sync war state: " . $e->getMessage());
        }
        
        $maps = $this->syncMaps($shard);     // grab the map list from API + DB

        // Loop through each map and sync extra data
        foreach ($maps as $name) {
            try {
                $this->syncWarReport($name, $shard); // fetch & store war report stats
            } catch (\Exception $e) {
                $this->info("Failed to sync war report for $name: " . $e->getMessage());
            }
            
            try {
                $this->syncDynamic($name, $shard);   // fetch & store live map icons
            } catch (\Exception $e) {
                $this->info("Failed to sync dynamic data for $name: " . $e->getMessage());
            }
        }

        $this->info("Foxhole sync complete for shard: {$shard}."); // end log
    }

    // Helper to convert ms timestamps to Carbon dates
    private function ts(?int $ms): ?\Carbon\Carbon
    {
        if (!$ms) return null; // if no timestamp, just return null

        // If Carbon has ms method, use it. Else fall back to seconds.
        return method_exists(Carbon::class, 'createFromTimestampMs')
            ? Carbon::createFromTimestampMs($ms)
            : Carbon::createFromTimestamp(intval($ms / 1000));
    }

    // Pull the war state from API and update DB
    private function syncWar(string $shard): void
    {
        $data = $this->api->war(); // call the API
        if (!$data) { // if API gave nothing, skip
            $this->info("No war data returned.");
            return;
        }

        // Update or insert war record
        WarState::updateOrCreate(
            ['war_id' => $data['warId'], 'shard' => $shard], // look up by war_id AND shard
            [
                'war_number' => $data['warNumber'] ?? null, // war # if any
                'winner' => $data['winner'] ?? 'NONE',      // winner side or NONE
                'conquest_start' => $this->ts($data['conquestStartTime'] ?? null),
                'conquest_end' => $this->ts($data['conquestEndTime'] ?? null),
                'resistance_start' => $this->ts($data['resistanceStartTime'] ?? null),
                'scheduled_conquest_end' => $this->ts($data['scheduledConquestEndTime'] ?? null),
                'required_victory_towns' => $data['requiredVictoryTowns'] ?? null,
                'short_required_victory_towns' => $data['shortRequiredVictoryTowns'] ?? null,
            ]
        );

        $this->info("War state synced."); // log it
    }

    // Get all map names and make sure they exist in DB
    private function syncMaps(string $shard): array
    {
        $data = $this->api->maps(); // API returns array of map names
        if ($data) {
            foreach ($data as $name) {
                // Only create if map doesn't exist yet for this shard
                MapModel::firstOrCreate(['name' => $name, 'shard' => $shard]);
            }
            $this->info("Maps synced: " . count($data)); // log map count
        } else {
            $this->info("No maps returned."); // log if API empty
        }

        // Return full list of maps from DB for this shard sorted by name
        return MapModel::where('shard', $shard)->orderBy('name')->pluck('name')->all();
    }

    // Store war report for a single map
    private function syncWarReport(string $map, string $shard): void
    {
        $data = $this->api->warReport($map); // get war report
        if (!$data) { // no data? skip
            $this->info("No war report for map: $map");
            return;
        }

        // Create new report entry
        MapReport::create([
            'map_name' => $map, // which map this report is for
            'shard' => $shard,
            'total_enlistments' => $data['totalEnlistments'] ?? 0,
            'colonial_casualties' => $data['colonialCasualties'] ?? 0,
            'warden_casualties' => $data['wardenCasualties'] ?? 0,
            'day_of_war' => $data['dayOfWar'] ?? 0,
            'fetched_at' => now(), // store when we fetched this
        ]);

        $this->info("War report synced for map: $map");
    }

    // Store dynamic icons (bases, facilities, etc.) for a single map
    private function syncDynamic(string $map, string $shard): void
    {
        $payload = $this->api->dynamic($map); // get dynamic map data
        if (!$payload) { // no data? skip
            $this->info("No dynamic data for map: $map");
            return;
        }

        // Latest war_id from DB for this shard, or fallback if nothing in DB yet
        $warId = optional(WarState::where('shard', $shard)->latest('updated_at')->first())->war_id ?? 'unknown';
        $items = $payload['mapItems'] ?? []; // the icons from API
        $lastUpdated = $payload['lastUpdated'] ?? null; // ms timestamp
        $version = $payload['version'] ?? null; // version #

        // Run insert/update in a transaction so it's atomic
        DB::transaction(function () use ($items, $map, $warId, $version, $lastUpdated, $shard) {
            foreach ($items as $it) {
                // Format x/y to fixed 8 decimal places (matches DB schema)
                $x = number_format($it['x'], 8, '.', '');
                $y = number_format($it['y'], 8, '.', '');

                // Unique key to match existing DB row
                $key = [
                    'war_id'   => $warId,
                    'shard'    => $shard,
                    'map_name' => $map,
                    'icon_type'=> $it['iconType'],
                    'x'        => $x,
                    'y'        => $y,
                ];

                // The fields we update if record already exists
                $values = [
                    'team_id'  => $it['teamId'] ?? 'NONE',
                    'flags'    => $it['flags'] ?? 0,
                    'version'  => $version,
                    'last_updated_ms' => $lastUpdated,
                ];

                // Update row if exists, else insert new one
                MapIcon::updateOrCreate($key, $values);
            }
        });

        // log count of synced items
        $this->info("Dynamic map icons synced for map: $map (items: ".count($items).")");
    }

    // Simple helper to echo info only in CLI mode
    private function info(string $msg): void
    {
        if (php_sapi_name() === 'cli') { // only output if running via artisan
            echo "[FoxholeSync] $msg\n";
        }
    }
}
