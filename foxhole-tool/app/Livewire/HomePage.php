<?php


namespace App\Livewire;

use Livewire\Component;
use App\Traits\LivewireLayoutStub;


class HomePage extends Component
{
    public function render()
    {
        return view('livewire.home-page')->layout('layouts.app');
    }
}
