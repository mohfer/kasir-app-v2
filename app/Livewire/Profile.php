<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

    #[Validate('required')]
    public $jenis_kelamin;

    #[Validate('required|unique:users|email')]
    public $email;

    #[Validate('required|unique:users|max:16')]
    public $telp;

    #[Validate('image|max:2048')]
    public $photo;

    public $title = 'Profile';
    public $role;
    public $nama;
    public $fileName;
    public $newFileName;
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
        if ($this->photo) {
            $this->fileName = md5($this->photo . microtime()) . '.' . $this->photo->extension();
            $this->photo->storeAs('photos', $this->fileName);

            if ($user->foto) {
                Storage::delete('photos/' . $user->foto);
            }
            $user->foto = $this->newFileName;
        }

        $newData = [
            'jenis_kelamin' => $this->jenis_kelamin,
            'email' => $this->email,
            'telp' => $this->telp,
            'foto' => $this->fileName,
        ];

        $isChanged = $user->jenis_kelamin != $newData['jenis_kelamin'] ||
            $user->email != $newData['email'] ||
            $user->telp != $newData['telp'] ||
            $user->foto != $newData['foto'];

        if (!$isChanged) {
            session()->flash('status', 'Tidak ada perubahan yang dilakukan.');
        } else {
            $user->update($newData);
            session()->flash('status', 'Data Berhasil Diperbarui!');
        }
    }

    public function render()
    {
        view()->share('title', $this->title);
        return view('livewire.profile');
    }
}
