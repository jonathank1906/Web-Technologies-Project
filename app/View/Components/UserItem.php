<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserItem extends Component
{
    public $name;

    public $description;

    public $l1;

    public $l2;

    private $_tempAvailableEmojis = [
        '👶', '🧒', '👦', '👧', '🧑', '👨', '👩', '🧓', '👴', '👵',
        '👱', '👱‍♂️', '👱‍♀️', '🧑‍🦰', '🧑‍🦱', '🧑‍🦳', '🧑‍🦲',
        '👨‍🦰', '👩‍🦰', '👨‍🦱', '👩‍🦱', '👨‍🦳', '👩‍🦳', '👨‍🦲', '👩‍🦲',
        '🧔', '🧔‍♂️', '🧔‍♀️', '🧕', '👳', '👳‍♂️', '👳‍♀️', '👲',
        '👮', '👮‍♂️', '👮‍♀️', '👷', '👷‍♂️', '👷‍♀️', '💂', '💂‍♂️', '💂‍♀️',
    ];

    public $_tempEmoji;

    private $_availableCountries = ['lv', 'us', 'de', 'br', 'fr'];

    public $country;

    public function __construct($name = null, $description = null, $l1 = null, $l2 = null)
    {
        $this->name = $name ?? fake()->name();
        $this->description = $description ?? fake()->sentence();
        $this->l1 = $l1 ?? strtoupper(fake()->languageCode());
        $this->l2 = $l2 ?? strtoupper(fake()->languageCode());
        $this->_tempEmoji = $this->_tempAvailableEmojis[array_rand($this->_tempAvailableEmojis)];
        $this->country = $this->_availableCountries[array_rand($this->_availableCountries)];

    }

    public function render()
    {
        return view('components.user-item');
    }
}
