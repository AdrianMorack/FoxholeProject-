<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use App\Models\MapIcon;
use App\Models\Map;
use App\Models\WarState;

class HomePage extends Component
{
    public $stats = [];

    public function mount()
    {
        $shard = session('foxhole_shard', 'baker');
        
        // Cache stats for 5 minutes per shard
        $this->stats = Cache::remember("homepage_stats_{$shard}", 300, function () use ($shard) {
            $warState = WarState::where('shard', $shard)->latest()->first();
            $warId = $warState?->war_id;
            
            // Calculate war day from conquest start time
            $warDay = 0;
            if ($warState && $warState->conquest_start) {
                $warDay = floor($warState->conquest_start->diffInDays(now()));
            }
            
            // Town Halls are icon types 56 (T1), 57 (T2), 58 (T3) - only count Victory Points (flag 41)
            // Count unique positions to avoid counting upgraded town halls multiple times, then subtract 1
            return [
                'current_war' => $warState?->war_number ?? 'Unknown',
                'war_day' => $warDay,
                'total_maps' => Map::where('shard', $shard)->count(),
                'total_townhalls' => MapIcon::where('shard', $shard)
                    ->where('war_id', $warId)
                    ->where('flags', 41)
                    ->whereIn('icon_type', [56, 57, 58])
                    ->selectRaw('COUNT(DISTINCT CONCAT(map_name, "|", x, "|", y)) as count')
                    ->first()->count ?? 0,
                'warden_townhalls' => MapIcon::where('shard', $shard)
                    ->where('war_id', $warId)
                    ->where('team_id', 'WARDENS')
                    ->where('flags', 41)
                    ->whereIn('icon_type', [56, 57, 58])
                    ->selectRaw('COUNT(DISTINCT CONCAT(map_name, "|", x, "|", y)) as count')
                    ->first()->count - 1 ?? 0,
                'colonial_townhalls' => MapIcon::where('shard', $shard)
                    ->where('war_id', $warId)
                    ->where('team_id', 'COLONIALS')
                    ->where('flags', 41)
                    ->whereIn('icon_type', [56, 57, 58])
                    ->selectRaw('COUNT(DISTINCT CONCAT(map_name, "|", x, "|", y)) as count')
                    ->first()->count - 1 ?? 0,
                'townhalls_to_win' => $warState?->required_victory_towns ?? 32,
                'last_updated_at' => $warState?->updated_at,
            ];
        });
    }

    public function render()
    {
        return view('livewire.home-page')
            ->layout('layouts.app', ['title' => 'Allied Command']);
    }
}
