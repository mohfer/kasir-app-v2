<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class Profile extends Component
{

    #[Validate('required')]
    public $jenis_kelamin;

    #[Validate('required|unique:users|email')]
    public $email;

    #[Validate('required|unique:users|max:16')]
    public $telp;

    public $title = 'Profile';
    public $role;
    public $nama;
    public $username;

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

    public function save()
    {
        $user = User::find(Auth::user()->id);

        $newData = [
            'jenis_kelamin' => $this->jenis_kelamin,
            'email' => $this->email,
            'telp' => $this->telp,
        ];

        $isChanged = $user->jenis_kelamin != $newData['jenis_kelamin'] ||
            $user->email != $newData['email'] ||
            $user->telp != $newData['telp'];

        if (!$isChanged) {
            session()->flash('status', 'Tidak ada perubahan yang dilakukan.');
        }


        $user->update($newData);

        session()->flash('status', 'Data Berhasil Diperbarui!');
    }

    public function render()
    {
        view()->share('title', $this->title);
        return view('livewire.profile');
    }
}
