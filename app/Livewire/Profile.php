<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{

    public $title = 'Profile';
    public $role;
    public $nama;
    public $username;
    public $jenis_kelamin;
    public $email;
    public $telp;

    public function mount()
    {
        $user = Auth::user();
        $this->role = $user->role;
        $this->nama = $user->nama;
        $this->username = $user->username;
        $this->jenis_kelamin = $user->jenis_kelamin;
        $this->email = $user->email;
        $this->telp = $user->telp;
    }

    public function render()
    {
        view()->share('title', $this->title);
        return view('livewire.profile');
    }
}
