<?php

namespace App\Livewire\Swipe;
use App\Models\User;

use Livewire\Component;

class Item extends Component
{
    public function render()
    {
        $users = User::where('id', '<>', auth()->id())->get();
        return view('livewire.swipe.item', compact('users'));
    }
}
