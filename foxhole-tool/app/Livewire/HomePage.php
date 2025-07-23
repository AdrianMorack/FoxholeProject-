<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;


class HomePage extends Component
{
    public $maps = [];
    public $data;

    public function mount()
    {
        $this->data = Http::get('https://war-service-live.foxholeservices.com/api/worldconquest/maps')->json();
    }

    public function render()
    {
        return view('livewire.home-page')
            ->layout('layouts.app', ['title' => 'Home Page']);
        return view('livewire.home-page')->layout('layouts.app');
    }
}
