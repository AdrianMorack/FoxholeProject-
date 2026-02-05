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
        // Cache map list for 5 minutes to avoid repeated queries
        $this->maps = Cache::remember('map_list', 300, function () {
            return MapIcon::select('map_name')
                ->selectRaw('COUNT(*) as icon_count')
                ->selectRaw('COUNT(DISTINCT team_id) as team_count')
                ->whereIn('icon_type', [56, 57, 58])
                ->groupBy('map_name')
                ->orderBy('map_name')
                ->get()
                ->map(function ($map) {
                    return [
                        'name' => $map->map_name,
                        'display_name' => str_replace('Hex', ' Hex', $map->map_name),
                        'icon_count' => $map->icon_count,
                        'team_count' => $map->team_count,
                    ];
                })
                ->toArray();
        });
    }

    public function render()
    {
        return view('livewire.map-list')
            ->layout('layouts.app', ['title' => 'War Maps']);
    }
}
