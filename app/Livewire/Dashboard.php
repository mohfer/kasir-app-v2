<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $title = 'Dashboard';
    public function logout()
    {
        Auth::logout();

        return redirect()->route('auth.login');
    }
    public function render()
    {
        view()->share('title', $this->title);
        return view('livewire.dashboard');
    }
}
