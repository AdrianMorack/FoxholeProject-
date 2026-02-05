<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MapIcon;
use Illuminate\Support\Facades\Log;

class MapViewer extends Component
{
    public $towns = [];
    public $selectedMap;

    public function mount($mapName = 'CallahansPassageHex')
    {
        $this->selectedMap = $mapName;
        
        // Fetch icons for the selected hex only
        $icons = MapIcon::where('map_name', $this->selectedMap)
            ->whereIn('icon_type', [56, 57, 58])
            ->get(['x', 'y', 'team_id', 'icon_type', 'map_name']);

        // Assign default team colors
        $teamColors = [
            'WARDENS'   => '#0000ff',
            'COLONIALS' => '#00ff00',
            'NONE' => '#000000',
        ];

        $this->towns = $icons->map(function ($icon) use ($teamColors) {
            $teamId = strtoupper($icon->team_id ?? 'NONE');
            
            // Map icon types to names
            $iconNames = [
                56 => 'Town Hall',
                57 => 'Relic Base',
                58 => 'Keep',
            ];
            
            return [
                'x' => isset($icon->x) ? (float)$icon->x : 0.5,
                'y' => isset($icon->y) ? (float)$icon->y : 0.5,
                'size' => 0.03,
                'team_color' => $teamColors[$teamId] ?? '#ff0000',
                'team_id' => $teamId,
                'icon_type' => $icon->icon_type ?? 0,
                'icon_name' => $iconNames[$icon->icon_type] ?? 'Unknown',
                'map_name' => $icon->map_name ?? '',
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
