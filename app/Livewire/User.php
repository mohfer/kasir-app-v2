<?php

namespace App\Livewire;

use Livewire\Component;

class User extends Component
{

    public $title = 'Users';

    public function render()
    {
        view()->share('title', $this->title);
        return view('livewire.user');
    }
}
