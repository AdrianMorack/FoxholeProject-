<?php

namespace App\Livewire;

use Livewire\Component; // Base Livewire component class
use Illuminate\Support\Facades\Http; // HTTP client for making API requests
use Illuminate\Support\Facades\Cache; // Cache facade for caching API responses

class WarStatus extends Component
{
    /**
     * ====== Public properties ======
     * Livewire automatically exposes these to the Blade view.
     *
     * @var array|null
     */
    public $data; // Holds the current war status data fetched from the Foxhole API

    /**
     * ====== Component render ======
     * Returns the Blade view that represents this Livewire component.
     */
    public function render()
    {
        return view('livewire.war-status') // Blade view file: resources/views/livewire/war-status.blade.php
            ->layout('layouts.app', ['title' => 'War Status']); // Uses app layout and sets page title
    }

    /**
     * ====== Component mount ======
     * Called once when the component is first instantiated.
     * Good place to fetch initial data.
     */
    public function mount()
    {
        // Cache war status for 5 minutes to avoid slow API calls on every page load
        $this->data = Cache::remember('war_status', 300, function () {
            try {
                $response = Http::timeout(10)
                    ->retry(2, 100)
                    ->get('https://war-service-live.foxholeservices.com/api/worldconquest/war');
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                return null;
            } catch (\Exception $e) {
                \Log::error('Failed to fetch war status: ' . $e->getMessage());
                return null;
            }
        });
    }
}
