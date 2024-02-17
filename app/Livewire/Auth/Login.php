<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    #[Validate('required')]
    public $username, $password;

    public $showPassword = false;
    public $title = 'Login';

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            return $this->redirect('/dashboard', navigate: true);
        } else {
            session()->flash('error', 'Login Gagal!');
            $this->password = '';
        }
    }

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }
    public function render()
    {
        view()->share('title', $this->title);
        return view('livewire.auth.login');
    }
}
