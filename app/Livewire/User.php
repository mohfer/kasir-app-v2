<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class User extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Validate('required')]
    public $nama, $selectedRole;

    #[Validate('required|unique:users')]
    public $username;

    public $title = 'Users';
    public $jenis_kelamin;
    public $email;
    public $telp;
    public $user_id;
    public $searchKey;
    public $countUsers;
    public $sortColumn = 'nama';
    public $sortDirection = 'asc';

    public function mount()
    {
        $this->selectedRole = 'Admin';
        $user = ModelsUser::findOrFail(auth()->id());
        $this->jenis_kelamin = $user->jenis_kelamin;
    }

    public function save()
    {
        $this->validate();

        ModelsUser::create([
            'nama' => $this->nama,
            'username' => strtolower($this->username),
            'password' => strtolower($this->nama),
            'jenis_kelamin' => '',
            'role' => $this->selectedRole,
            'foto' => null,
        ]);

        session()->flash('status', 'Data Berhasil Ditambah!');
        $this->clear();
    }

    public function edit($id)
    {
        $user = ModelsUser::find($id);
        $this->nama = $user->nama;
        $this->username = $user->username;
        $this->jenis_kelamin = $user->jenis_kelamin;
        $this->email = $user->email;
        $this->telp = $user->telp;
        $this->selectedRole = $user->role;

        $this->user_id = $id;
    }

    public function update()
    {
        $user = ModelsUser::find($this->user_id);

        $newData = [
            'nama' => $this->nama,
            'role' => $this->selectedRole,
        ];

        $isChanged = $user->nama != $newData['nama'] ||
            $user->role != $newData['role'];

        if (!$isChanged) {
            session()->flash('status', 'Tidak ada perubahan yang dilakukan.');
            return $this->redirect('/users', navigate: true);
        }

        $this->validate([
            'nama' => 'required|unique:users,nama,' . $this->user_id,
        ]);

        $user->update($newData);

        session()->flash('status', 'Data Berhasil Diperbarui!');
        return $this->redirect('/users', navigate: true);
    }

    public function deleteConfirmation($id)
    {
        $this->user_id = $id;
    }

    public function delete()
    {
        $id = $this->user_id;
        $userHasTransactions = Transaction::where('user_id', $id)->exists();

        if ($userHasTransactions) {
            session()->flash('error', 'Data tidak dapat dihapus karena masih dibutuhkan di halaman laporan.');
        } else {
            ModelsUser::find($id)->delete();
            $user = ModelsUser::find(Auth::user()->id);
            Storage::delete('photos/' . $user->foto);
            session()->flash('status', 'Data Berhasil Dihapus!');
        }

        return $this->redirect('/users', navigate: true);
    }


    public function updatingSearchKey()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->nama = '';
        $this->username = '';
        $this->selectedRole = '';
        $this->resetErrorBag();
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        view()->share('title', $this->title);
        if ($this->searchKey != null) {
            $users = ModelsUser::where('nama', 'LIKE', '%' . $this->searchKey . '%')->orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        } else {
            $users = ModelsUser::orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        }
        $this->countUsers = ModelsUser::count();
        return view('livewire.user', [
            'users' => $users
        ]);
    }
}
