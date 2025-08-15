<?php

namespace App\Services;

use App\Models\{WarState, Map as MapModel, MapReport, MapIcon};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FoxholeSyncService
{
    public function __construct(private FoxholeApi $api) {}

    public function run(): void
    {
        $this->info("Starting Foxhole sync...");

        $this->syncWar();
        $maps = $this->syncMaps();

        foreach ($maps as $name) {
            $this->syncWarReport($name);
            $this->syncDynamic($name);
        }

        $this->info("Foxhole sync complete.");
    }

    private function ts(?int $ms): ?\Carbon\Carbon
    {
        if (!$ms) return null;
        return method_exists(Carbon::class, 'createFromTimestampMs')
            ? Carbon::createFromTimestampMs($ms)
            : Carbon::createFromTimestamp(intval($ms / 1000));
    }

    private function syncWar(): void
    {
        $data = $this->api->war();
        if (!$data) {
            $this->info("No war data returned.");
            return;
        }

        WarState::updateOrCreate(
            ['war_id' => $data['warId']],
            [
                'war_number' => $data['warNumber'] ?? null,
                'winner' => $data['winner'] ?? 'NONE',
                'conquest_start' => $this->ts($data['conquestStartTime'] ?? null),
                'conquest_end' => $this->ts($data['conquestEndTime'] ?? null),
                'resistance_start' => $this->ts($data['resistanceStartTime'] ?? null),
                'scheduled_conquest_end' => $this->ts($data['scheduledConquestEndTime'] ?? null),
                'required_victory_towns' => $data['requiredVictoryTowns'] ?? null,
                'short_required_victory_towns' => $data['shortRequiredVictoryTowns'] ?? null,
            ]
        );

        $this->info("War state synced.");
    }

    private function syncMaps(): array
    {
        $data = $this->api->maps();
        if ($data) {
            foreach ($data as $name) {
                MapModel::firstOrCreate(['name' => $name]);
            }
            $this->info("Maps synced: " . count($data));
        } else {
            $this->info("No maps returned.");
        }

        return MapModel::orderBy('name')->pluck('name')->all();
    }

    private function syncWarReport(string $map): void
    {
        $data = $this->api->warReport($map);
        if (!$data) {
            $this->info("No war report for map: $map");
            return;
        }

        MapReport::create([
            'map_name' => $map,
            'total_enlistments' => $data['totalEnlistments'] ?? 0,
            'colonial_casualties' => $data['colonialCasualties'] ?? 0,
            'warden_casualties' => $data['wardenCasualties'] ?? 0,
            'day_of_war' => $data['dayOfWar'] ?? 0,
            'fetched_at' => now(),
        ]);

        $this->info("War report synced for map: $map");
    }

    private function syncDynamic(string $map): void
    {
        $payload = $this->api->dynamic($map);
        if (!$payload) {
            $this->info("No dynamic data for map: $map");
            return;
        }

        $warId = optional(WarState::latest('updated_at')->first())->war_id ?? 'unknown';
        $items = $payload['mapItems'] ?? [];
        $lastUpdated = $payload['lastUpdated'] ?? null;
        $version = $payload['version'] ?? null;

        DB::transaction(function () use ($items, $map, $warId, $version, $lastUpdated) {
            foreach ($items as $it) {
                // Normalize x/y to match DECIMAL(10,8) and prevent duplicates
                $x = number_format($it['x'], 8, '.', '');
                $y = number_format($it['y'], 8, '.', '');

                $key = [
                    'war_id'   => $warId,
                    'map_name' => $map,
                    'icon_type'=> $it['iconType'],
                    'x'        => $x,
                    'y'        => $y,
                ];

                $values = [
                    'team_id'  => $it['teamId'] ?? 'NONE',
                    'flags'    => $it['flags'] ?? 0,
                    'version'  => $version,
                    'last_updated_ms' => $lastUpdated,
                ];

                MapIcon::updateOrCreate($key, $values);
            }
        });

        $this->info("Dynamic map icons synced for map: $map (items: ".count($items).")");
    }

    // Optional helper for debugging in CLI
    private function info(string $msg): void
    {
        if (php_sapi_name() === 'cli') {
            echo "[FoxholeSync] $msg\n";
        }
    }
}
