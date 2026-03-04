<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MapIcon;
use App\Models\MapTextItem;
use App\Models\WarState;
use Illuminate\Support\Facades\Log;

class MapViewer extends Component
{
    public $towns = [];
    public $selectedMap;
    public bool $shardOffline = false;

    public function mount($mapName = 'CallahansPassageHex')
    {
        $this->selectedMap = $mapName;
        $shard = session('foxhole_shard', 'baker');
        
        // Get the most recent war_id that actually has MapIcon data
        $latestWarId = MapIcon::where('shard', $shard)
            ->orderBy('updated_at', 'desc')
            ->value('war_id');
        
        if (!$latestWarId) {
            Log::warning("No MapIcon data found for shard: {$shard}, attempting fallback.");
            $this->shardOffline = true;

            // Try any other shard — map geography (icon positions) is the same across shards
            $latestWarId = MapIcon::orderBy('updated_at', 'desc')->value('war_id');

            if (!$latestWarId) {
                $this->towns = [];
                return;
            }
        }

        // Fetch Town Halls (56, 57, 58 = T1, T2, T3) and Relic Bases (45, 46, 47 = 3 designs)
        $icons = MapIcon::where('map_name', $this->selectedMap)
            ->when(!$this->shardOffline, fn($q) => $q->where('shard', $shard))
            ->where('war_id', $latestWarId)
            ->whereIn('icon_type', [45, 46, 47, 56, 57, 58])
            ->get(['x', 'y', 'team_id', 'icon_type', 'flags', 'updated_at']);
        
        // Remove duplicates at same location - keep only the most recently updated one
        $uniqueIcons = $icons->groupBy(fn($icon) => round($icon->x, 6) . ',' . round($icon->y, 6))
            ->map(function ($group) {
                // If multiple icons at same location, return the most recently updated
                return $group->sortByDesc('updated_at')->first();
            })
            ->values();

        Log::info("MapViewer loaded {$uniqueIcons->count()} icons for {$this->selectedMap} (war: {$latestWarId})");

        // Load all text label locations for this map so we can name each icon
        // Don't filter by war_id — static labels rarely change war-to-war and
        // this way we still get names even if text items are from a prior war sync
        $textItems = MapTextItem::where('map_name', $this->selectedMap)
            ->where('shard', $shard)
            ->get(['text', 'x', 'y', 'map_marker_type'])
            ->toArray();

        // Fallback: geography is the same on both shards — use whichever has data
        if (empty($textItems)) {
            $textItems = MapTextItem::where('map_name', $this->selectedMap)
                ->get(['text', 'x', 'y', 'map_marker_type'])
                ->toArray();
        }

        // Team colors
        $teamColors = [
            'WARDENS'   => '#235682',
            'COLONIALS' => '#506c4b',
            'NONE' => '#6c6c6c',
        ];

        $shardOffline = $this->shardOffline;

        $this->towns = $uniqueIcons->map(function ($icon) use ($teamColors, $textItems, $shardOffline) {
            // If shard is offline, force neutral — we don't know actual ownership
            $teamId = $shardOffline ? 'NONE' : strtoupper($icon->team_id ?? 'NONE');
            $iconType = $icon->icon_type ?? 0;
            
            // Determine structure type and shape
            // 56, 57, 58 = Town Hall Tier 1, 2, 3 (squares)
            // 45, 46, 47 = Relic Base designs (circles)
            $isRelic = in_array($iconType, [45, 46, 47]);
            $isTownHall = in_array($iconType, [56, 57, 58]);

            // Find the nearest map text label to this icon coordinate
            $locationName = null;
            $closestDist = PHP_FLOAT_MAX;
            foreach ($textItems as $label) {
                $dist = (($icon->x - $label['x']) ** 2) + (($icon->y - $label['y']) ** 2);
                if ($dist < $closestDist) {
                    $closestDist = $dist;
                    $locationName = $label['text'];
                }
            }

            // Fallback name if no text items exist yet (before first static sync)
            if (!$locationName) {
                if ($isRelic) {
                    $locationName = 'Relic Base';
                } elseif ($isTownHall) {
                    $tier = $iconType - 55;
                    $locationName = "Town Hall T{$tier}";
                } else {
                    $locationName = 'Unknown';
                }
            }

            // Keep a short type label for the tooltip
            if ($isRelic) {
                $typeName = 'Relic Base';
            } elseif ($isTownHall) {
                $tier = $iconType - 55;
                $typeName = "Town Hall T{$tier}";
            } else {
                $typeName = 'Unknown';
            }
            
            return [
                'x' => (float)$icon->x,
                'y' => (float)$icon->y,
                'team_color' => $teamColors[$teamId] ?? '#ff0000',
                'team_id' => $teamId,
                'icon_type' => $iconType,
                'icon_name' => $locationName,
                'type_name' => $typeName,
                'shape' => $isRelic ? 'circle' : 'square',
                'flags' => $icon->flags ?? 0,
            ];
        })->toArray();
    }

    public function render()
    {
        $displayName = str_replace('Hex', ' Hex', $this->selectedMap);
        return view('livewire.map-viewer')
            ->layout('layouts.app', ['title' => $displayName]);
    }
}
