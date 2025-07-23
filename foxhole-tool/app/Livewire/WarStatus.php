<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class WarStatus extends Component
{

    public $data;

    public function render()
{
    return view('livewire.war-status')
        ->layout('layouts.app', ['title' => 'War Status']);
}

    public function mount()
    {
        $this->data = Http::get('https://war-service-live.foxholeservices.com/api/worldconquest/war')->json();
    }


}
