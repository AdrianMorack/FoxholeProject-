<?php

namespace App\Livewire;

use Livewire\Component; // Base Livewire component class
use Illuminate\Support\Facades\Http; // HTTP client for making API requests

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
        // Fetch current war data from Foxhole API and decode JSON response
        $this->data = Http::get('https://war-service-live.foxholeservices.com/api/worldconquest/war')
                          ->json();
    }
}
