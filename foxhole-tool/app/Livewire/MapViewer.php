<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MapIcon;
use Illuminate\Support\Facades\Log;
class MapViewer extends Component
{
    public $towns = [];

    public function mount()
    {
        // Fetch the town/hex icons you want to display
        $icons = MapIcon::whereIn('icon_type', [56, 57, 58])
            ->get(['x', 'y', 'team_id', 'icon_type', 'map_name']); // only fields we actually use

        // Assign default team colors
        $teamColors = [
            'WARDENS'   => '#0000ff',
            'COLONIALS' => '#00ff00',
            'NONE' => '#000000',
        ];

        $this->towns = $icons->map(function ($icon) use ($teamColors) {
            $teamId = strtoupper($icon->team_id ?? 'NONE');
            Log::info('MapViewer TeamName:', ['team_id' => $icon->team_id]);            return [
                'x' => isset($icon->x) ? (float)$icon->x : 0.5,  // fallback to center
                'y' => isset($icon->y) ? (float)$icon->y : 0.5,  // fallback to center
                'size' => 0.03,                                  // fraction of map width
                'team_color' => $teamColors[$icon->team_id] ?? '#ff0000', // fallback color
                'type' => $icon->icon_type ?? 'NO TYPE',            // fallback name
                
            ];
        })->toArray();

        // Debugging: log towns to storage/logs/laravel.log
        Log::info('MapViewer towns:', $this->towns);
        
    }

    public function render()
    {
        return view('livewire.map-viewer')
            ->layout('layouts.app', ['title' => 'Map Viewer']);
    }
}
