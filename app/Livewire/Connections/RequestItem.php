<?php

namespace App\Livewire\Connections;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class RequestItem extends Component
{
    protected $listeners = ['openProfile'];

    public $user;

    public $name;

    public $language1;

    public $language2;

    public $countryCode;

    public $avatarUrl;

    public $flagUrl;

    public $status;

    public function mount($user = null)
    {
        $this->user = $user;
        $this->name = $user->name ?? 'Unknown User';
        $this->language1 = $user->language1 ?? '??';
        $this->language2 = $user->language2 ?? '??';
        $this->countryCode = $user->countryCode ?? null;
        $this->status = $user->status ?? 'No status';
        $this->avatarUrl = ($user && $user->profile_picture && Storage::disk('public')->exists($user->profile_picture))
            ? Storage::url($user->profile_picture)
            : null;
        $this->flagUrl = $this->countryCode
            ? "https://cdn.jsdelivr.net/gh/lipis/flag-icons/flags/4x3/{$this->countryCode}.svg"
            : 'https://placehold.co/120x120?text=??';
    }

    public function openProfile()
    {
        return redirect()->route('profile.user', ['user' => $this->user->id]);
    }

    public function render()
    {
        return view('livewire.connections.request-item');
    }
}
