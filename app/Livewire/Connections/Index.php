<?php

namespace App\Livewire\Connections;

use Livewire\Component;

class Index extends Component
{
    public $requests = true;
    public function render()
    {
        return view('livewire.connections.index');
    }
}
