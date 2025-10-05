<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserItem extends Component
{
    public $name;
    public $description;

    public $l1;
    public $l2;

    public function __construct($name = null, $description = null, $l1 = null, $l2 = null)
    {
        $this->name = $name ?? fake()->name();
        $this->description = $description ?? fake()->sentence();
        $this->l1 = $l1 ?? fake()->languageCode();
        $this->l2 = $l2 ?? fake()->languageCode();
    }

    public function render()
    {
        return view('components.user-item');
    }
}
