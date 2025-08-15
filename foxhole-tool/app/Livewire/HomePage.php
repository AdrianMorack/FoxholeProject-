<?php

namespace App\Livewire;

use Livewire\Component; // Base Livewire component class
use Illuminate\Support\Facades\Http; // Laravel HTTP client for API calls

class HomePage extends Component
{
    /**
     * ====== Public properties ======
     * Exposed to the Blade template for dynamic rendering.
     */
    public $mapNames = [];               // Holds the list of all map names from Foxhole API
    public $totalColonialCasualties = 0; // Aggregated colonial casualties (can be calculated later)
    public $totalWardenCasualties = 0;   // Aggregated warden casualties (can be calculated later)

    public $selectedMap;  // Stores the currently selected map
    public $mapDetails;   // Stores detailed static data for the selected map

    /**
     * ====== Component mount ======
     * Called when the component is first created.
     * Good for fetching initial data for the page.
     */
    public function mount()
    {
        // Fetch all map names from the Foxhole API and store in $mapNames
        $this->mapNames = Http::get('https://war-service-live.foxholeservices.com/api/worldconquest/maps')
                              ->json();
    }

    /**
     * ====== Component render ======
     * Determines which Blade view to use and layout.
     */
    public function render()
    {
        return view('livewire.home-page')                  // Blade view file: resources/views/livewire/home-page.blade.php
            ->layout('layouts.app', ['title' => 'Home Page']); // Use main app layout and set page title
    }

    /**
     * ====== Load map details ======
     * Called when a user selects a map to view more details.
     *
     * @param string $mapName Name of the map to fetch
     */
    public function loadMapData($mapName)
    {
        $this->selectedMap = $mapName; // Set the currently selected map

        // Fetch static map data from the Foxhole API
        $response = Http::get("https://war-service-live.foxholeservices.com/api/worldconquest/maps/{$mapName}/static");

        // Check if request succeeded
        if ($response->successful()) {
            $this->mapDetails = $response->json(); // Store JSON response in $mapDetails
        } else {
            $this->mapDetails = null; // Reset map details on failure
        }
    }
}
