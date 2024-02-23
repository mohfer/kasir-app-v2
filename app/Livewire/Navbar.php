<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $nama;

    public function mount()
    {
        $this->nama = Auth::user()->nama;
    }

    public function logout()
    {
        Auth::logout();

        return $this->redirect('/login', navigate: true);
    }
    public function render()
    {

        return view('livewire.navbar');
    }
}
