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
        // Cache stats for 5 minutes
        $this->stats = Cache::remember('homepage_stats', 300, function () {
            $warState = WarState::latest()->first();
            
            return [
                'current_war' => $warState?->war_id ?? 'Unknown',
                'war_day' => $warState ? floor($warState->war_duration_ms / (1000 * 60 * 60 * 24)) : 0,
                'total_maps' => Map::count(),
                'total_icons' => MapIcon::whereIn('icon_type', [56, 57, 58])->count(),
                'warden_icons' => MapIcon::where('team_id', 'WARDENS')->whereIn('icon_type', [56, 57, 58])->count(),
                'colonial_icons' => MapIcon::where('team_id', 'COLONIALS')->whereIn('icon_type', [56, 57, 58])->count(),
                'neutral_icons' => MapIcon::where('team_id', 'NONE')->whereIn('icon_type', [56, 57, 58])->count(),
                'last_updated' => $warState?->updated_at?->diffForHumans() ?? 'Never',
            ];
        });
    }

    public function render()
    {
        return view('livewire.home-page')
            ->layout('layouts.app', ['title' => 'Foxhole War Tracker']);
    }
}
