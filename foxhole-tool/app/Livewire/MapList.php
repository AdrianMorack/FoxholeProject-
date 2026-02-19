<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MapIcon;
use Illuminate\Support\Facades\Cache;

class MapList extends Component
{
    public $maps = [];

    public function mount()
    {
        $shard = session('foxhole_shard', 'baker');
        
        // Get the most recent war_id that actually has MapIcon data
        $latestWarId = MapIcon::where('shard', $shard)
            ->orderBy('updated_at', 'desc')
            ->value('war_id');
        
        if (!$latestWarId) {
            $this->maps = [];
            return;
        }
        
        // Cache map list for 5 minutes per shard to avoid repeated queries
        $this->maps = Cache::remember("map_list_{$shard}_{$latestWarId}", 300, function () use ($shard, $latestWarId) {
            // Get all icons for the current war, grouped by map and team
            $mapData = MapIcon::select('map_name', 'team_id', 'x', 'y', 'icon_type', 'updated_at')
                ->where('shard', $shard)
                ->where('war_id', $latestWarId)
                ->get()
                ->groupBy('map_name')
                ->map(function ($icons) {
                    // Deduplicate icons at same location - keep most recent
                    $uniqueIcons = $icons->groupBy(fn($icon) => round($icon->x, 6) . ',' . round($icon->y, 6))
                        ->map(fn($group) => $group->sortByDesc('updated_at')->first())
                        ->values();
                    
                    // Count by team (uppercase for consistency)
                    $wardenCount = $uniqueIcons->filter(fn($icon) => strtoupper($icon->team_id ?? '') === 'WARDENS')->count();
                    $colonialCount = $uniqueIcons->filter(fn($icon) => strtoupper($icon->team_id ?? '') === 'COLONIALS')->count();
                    $totalCount = $wardenCount + $colonialCount;
                    
                    // Calculate percentages
                    $wardenPercent = $totalCount > 0 ? ($wardenCount / $totalCount) * 100 : 0;
                    $colonialPercent = $totalCount > 0 ? ($colonialCount / $totalCount) * 100 : 0;
                    
                    return [
                        'total' => $totalCount,
                        'warden_count' => $wardenCount,
                        'colonial_count' => $colonialCount,
                        'warden_percent' => round($wardenPercent, 1),
                        'colonial_percent' => round($colonialPercent, 1),
                    ];
                })
                ->filter(fn($data) => $data['total'] > 0); // Only include maps with icons
            
            return $mapData->map(function ($data, $mapName) {
                return [
                    'name' => $mapName,
                    'display_name' => str_replace('Hex', '', $mapName),
                    'total_icons' => $data['total'],
                    'warden_count' => $data['warden_count'],
                    'colonial_count' => $data['colonial_count'],
                    'warden_percent' => $data['warden_percent'],
                    'colonial_percent' => $data['colonial_percent'],
                ];
            })->values()->toArray();
        });
    }

    public function render()
    {
        return view('livewire.map-list')
            ->layout('layouts.app', ['title' => 'Tactical War Map']);
    }
}
