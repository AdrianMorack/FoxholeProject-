<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class HomePage extends Component
{
    public $mapNames = [];
    public $totalColonialCasualties = 0;
    public $totalWardenCasualties = 0;

    public function mount()
    {
        $this->mapNames = Http::get('https://war-service-live.foxholeservices.com/api/worldconquest/maps')->json();
    }

    public function render()
    {
        return view('livewire.home-page')
            ->layout('layouts.app', ['title' => 'Home Page']);
    }

    public $selectedMap;
    public $mapDetails;

    public function loadMapData($mapName)
    {
        $this->selectedMap = $mapName;

        $response = Http::get("https://war-service-live.foxholeservices.com/api/worldconquest/maps/{$mapName}/static");

        if ($response->successful()) {
            $this->mapDetails = $response->json();
        } else {
            $this->mapDetails = null;
        }
    }

}
