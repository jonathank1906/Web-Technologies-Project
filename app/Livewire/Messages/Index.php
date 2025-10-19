<?php

namespace App\Livewire\Messages;

use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public $activeFriend = null;

    public array $friends = [
        [
            'id' => 1,
            'name' => 'Jonathan',
            'flag' => 'us',
            'img' => '🧔',
            'lang' => 'EN <-> ES',
            'messages' => ['Hey! You ready to chat?', 'I’ll send you notes.'],
        ],
        [
            'id' => 2,
            'name' => 'Lukas',
            'flag' => 'de',
            'img' => '👨‍🦱',
            'lang' => 'DE <-> FR',
            'messages' => ['I sent you a message yesterday.'],
        ],
        [
            'id' => 3,
            'name' => 'Deivid',
            'flag' => 'br',
            'img' => '🧒',
            'lang' => 'PT <-> EN',
            'messages' => ['Let’s learn together!'],
        ],
        [
            'id' => 4,
            'name' => 'Benjamin',
            'flag' => 'fr',
            'img' => '👨‍🦰',
            'lang' => 'FR <-> DE',
            'messages' => ['Bonjour! Ça va?'],
        ],
        [
            'id' => 5,
            'name' => 'Daniils',
            'flag' => 'lv',
            'img' => '🧑',
            'lang' => 'LV <-> EN',
            'messages' => ['See you later!', 'Sure let’s do it!'],
        ],
    ];

    public function selectFriend($id)
    {
        $this->activeFriend = collect($this->friends)->firstWhere('id', $id);
    }

    public function getFilteredFriendsProperty()
    {
        return collect($this->friends)
            ->filter(function ($friend) {
                return str_contains(strtolower($friend['name']), strtolower($this->search));
            })
            ->values()
            ->all();
    }

    public function render()
    {
        
        return view('livewire.messages.index');
    }
}
