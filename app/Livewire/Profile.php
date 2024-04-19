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

    #[Validate('nullable|image|max:2048')]
    public $photo;

    public $title = 'Profile';
    public $role;
    public $nama;
    public $fileName;
    public $newFileName;
    public $username;
    public $foto;

    public function mount()
    {
        $user = Auth::user();
        $this->role = $user->role;
        $this->nama = $user->nama;
        $this->username = $user->username;
        $this->jenis_kelamin = $user->jenis_kelamin;
        $this->email = $user->email;
        $this->telp = $user->telp;
        $this->foto = $user->foto;
    }

    public function save()
    {
        $this->validate([
            'photo' => 'nullable|image|max:2048',
        ]);

        $user = User::find(Auth::user()->id);

        $newFileName = null;

        if ($this->photo) {
            $newFileName = md5($this->photo . microtime()) . '.' . $this->photo->extension();
            $this->photo->storePubliclyAs(path: 'photos', name: $newFileName);

            if ($user->foto) {
                Storage::delete('photos/' . $user->foto);
            }
        }

        $newData = [
            'jenis_kelamin' => $this->jenis_kelamin,
            'email' => $this->email,
            'telp' => $this->telp,
        ];

        if ($newFileName) {
            $newData['foto'] = $newFileName;
        }

        $isChanged = $user->jenis_kelamin != $newData['jenis_kelamin'] ||
            $user->email != $newData['email'] ||
            $user->telp != $newData['telp'];

        if (isset($newData['foto'])) {
            $isChanged = $isChanged || $user->foto != $newData['foto'];
        }

        if (!$isChanged) {
            session()->flash('status', 'Tidak ada perubahan yang dilakukan.');
        } else {
            $user->update($newData);
            session()->flash('status', 'Data Berhasil Diperbarui!');
        }

        return $this->redirect('/profile', navigate: true);
    }

    public function render()
    {
        view()->share('title', $this->title);
        return view('livewire.profile');
    }
}
