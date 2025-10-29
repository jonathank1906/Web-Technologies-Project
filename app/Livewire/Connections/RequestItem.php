<?php

namespace App\Livewire\Connections;

use Livewire\Component;

class RequestItem extends Component
{
    protected $listeners = ['openProfile'];

    public $name;

    public $l1;

    public $l2;

    private $_tempAvailableStatuses = ['Online', 'Offline', 'Idle'];

    public $status;

    private $_tempAvailableEmojis = [
        '👶', '🧒', '👦', '👧', '🧑', '👨', '👩', '🧓', '👴', '👵',
        '👱', '👱‍♂️', '👱‍♀️', '🧑‍🦰', '🧑‍🦱', '🧑‍🦳', '🧑‍🦲',
        '👨‍🦰', '👩‍🦰', '👨‍🦱', '👩‍🦱', '👨‍🦳', '👩‍🦳', '👨‍🦲', '👩‍🦲',
        '🧔', '🧔‍♂️', '🧔‍♀️', '🧕', '👳', '👳‍♂️', '👳‍♀️', '👲',
        '👮', '👮‍♂️', '👮‍♀️', '👷', '👷‍♂️', '👷‍♀️', '💂', '💂‍♂️', '💂‍♀️',
    ];

    public $_tempEmoji;

    private $_tempAvailableCountries = ['lv', 'us', 'de', 'br', 'fr'];

    public $country;

    public function __construct()
    {
        $this->name = $name ?? fake()->name();
        $this->l1 = $l1 ?? strtoupper(fake()->languageCode());
        $this->l2 = $l2 ?? strtoupper(fake()->languageCode());
        $this->_tempEmoji = $this->_tempAvailableEmojis[array_rand($this->_tempAvailableEmojis)];
        $this->country = $this->_tempAvailableCountries[array_rand($this->_tempAvailableCountries)];
        $this->status = $this->_tempAvailableStatuses[array_rand($this->_tempAvailableStatuses)];
    }

    public function openProfile()
    {
        return redirect()->route('profile.show');
    }

    public function render()
    {
        return view('livewire.connections.request-item');
    }
}
