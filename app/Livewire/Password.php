<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class Password extends Component
{
    #[Validate('required')]
    public $oldPassword, $newPassword, $confirmPassword;

    public $title = 'Password';
    public $role;
    public $nama;
    public $foto;
    public $showPassword = false;

    public function mount()
    {
        $user = Auth::user();
        $this->role = $user->role;
        $this->nama = $user->nama;
        $this->foto = $user->foto;
    }

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function save()
    {
        $user = User::find(Auth::user()->id);

        $this->validate();

        if ($user) {
            if (password_verify($this->oldPassword, $user->password)) {
                if ($this->newPassword === $this->confirmPassword) {
                    $hashedPassword = password_hash($this->newPassword, PASSWORD_DEFAULT);
                    $user->password = $hashedPassword;
                    $user->save();
                    Auth::logout();
                    session()->flash('status', 'Password Berhasil Diubah, Silahkan Login Ulang!');
                    return $this->redirect('/login', navigate: true);
                } else {
                    session()->flash('status', 'Konfirmasi Password Tidak Sesuai.');
                }
            } else {
                session()->flash('status', 'Password Tidak Sesuai.');
            }
        } else {
            return false;
        }
    }

    public function render()
    {
        view()->share('title', $this->title);
        return view('livewire.password');
    }
}
