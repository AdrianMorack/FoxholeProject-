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
            
            // Town Halls are icon types 56 (T1), 57 (T2), 58 (T3) - only count Victory Points (flag 0x1)
            // Victory Point flag is bit 0x1, so we check if (flags & 1) == 1
            return [
                'current_war' => $warState?->war_number ?? 'Unknown',
                'war_day' => $warDay,
                'total_maps' => Map::where('shard', $shard)->count(),
                'total_townhalls' => MapIcon::where('shard', $shard)->where('war_id', $warId)->whereIn('icon_type', [56, 57, 58])->whereRaw('(flags & 1) = 1')->count(),
                'warden_townhalls' => MapIcon::where('shard', $shard)->where('war_id', $warId)->where('team_id', 'WARDENS')->whereIn('icon_type', [56, 57, 58])->whereRaw('(flags & 1) = 1')->count(),
                'colonial_townhalls' => MapIcon::where('shard', $shard)->where('war_id', $warId)->where('team_id', 'COLONIALS')->whereIn('icon_type', [56, 57, 58])->whereRaw('(flags & 1) = 1')->count(),
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
