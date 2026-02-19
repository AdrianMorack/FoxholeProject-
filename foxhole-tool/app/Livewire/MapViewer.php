<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MapIcon;
use App\Models\WarState;
use Illuminate\Support\Facades\Log;

class MapViewer extends Component
{
    public $towns = [];
    public $selectedMap;

    public function mount($mapName = 'CallahansPassageHex')
    {
        $this->selectedMap = $mapName;
        $shard = session('foxhole_shard', 'baker');
        
        // Get the most recent war_id that actually has MapIcon data
        $latestWarId = MapIcon::where('shard', $shard)
            ->orderBy('updated_at', 'desc')
            ->value('war_id');
        
        if (!$latestWarId) {
            Log::warning("No MapIcon data found for shard: {$shard}");
            $this->towns = [];
            return;
        }
        
        // Fetch Town Halls (56, 57, 58 = T1, T2, T3) and Relic Bases (45, 46, 47 = 3 designs)
        $icons = MapIcon::where('map_name', $this->selectedMap)
            ->where('shard', $shard)
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

        // Team colors
        $teamColors = [
            'WARDENS'   => '#235682',
            'COLONIALS' => '#506c4b',
            'NONE' => '#000000',
        ];

        $this->towns = $uniqueIcons->map(function ($icon) use ($teamColors) {
            $teamId = strtoupper($icon->team_id ?? 'NONE');
            $iconType = $icon->icon_type ?? 0;
            
            // Determine structure type and shape
            // 56, 57, 58 = Town Hall Tier 1, 2, 3 (squares)
            // 45, 46, 47 = Relic Base designs (circles)
            $isRelic = in_array($iconType, [45, 46, 47]);
            $isTownHall = in_array($iconType, [56, 57, 58]);
            
            // Determine name based on type
            if ($isRelic) {
                $name = 'Relic Base';
            } elseif ($isTownHall) {
                $tier = $iconType - 55; // 56->T1, 57->T2, 58->T3
                $name = "Town Hall T{$tier}";
            } else {
                $name = 'Unknown';
            }
            
            return [
                'x' => (float)$icon->x,
                'y' => (float)$icon->y,
                'team_color' => $teamColors[$teamId] ?? '#ff0000',
                'team_id' => $teamId,
                'icon_type' => $iconType,
                'icon_name' => $name,
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
