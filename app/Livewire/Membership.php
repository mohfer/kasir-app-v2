<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use App\Models\Membership as ModelsMembership;

class Membership extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Validate('required')]
    public $nama;

    #[Validate('required|numeric|max:100')]
    public $diskon;

    #[Validate('required|unique:memberships|max:13')]
    public $telp;

    #[Validate('required|unique:memberships|email|')]
    public $email;

    public $title = 'Membership';
    public $selectedAktif;
    public $tgl_berlangganan;

    public $member_id;
    public $kode_member;
    public $sortColumn = 'nama';
    public $sortDirection = 'asc';
    public $countMembers;
    public $searchKey;

    public function mount()
    {
        $this->generateKodeMember();
        $this->diskon = 5;
    }

    public function generateKodeMember()
    {
        $length = 3;
        $randomLetters = Str::random($length);
        $randomNumbers = mt_rand(100, 999);

        $this->kode_member = strtoupper($randomLetters) . $randomNumbers;
    }

    public function save()
    {
        $this->validate();

        ModelsMembership::create([
            'kode_member' => $this->kode_member,
            'nama' => $this->nama,
            'email' => $this->email,
            'telp' => $this->telp,
            'diskon' => 5,
            'tgl_berlangganan' => now()->toDateString(),
            'aktif' => 'Ya',
        ]);

        session()->flash('status', 'Data Berhasil Ditambah!');
        $this->clear();
    }

    public function edit($id)
    {
        $member = ModelsMembership::find($id);
        $this->kode_member = $member->kode_member;
        $this->nama = $member->nama;
        $this->email = $member->email;
        $this->telp = $member->telp;
        $this->tgl_berlangganan = $member->tgl_berlangganan;
        $this->diskon = $member->diskon;
        $this->selectedAktif = $member->aktif;

        $this->member_id = $id;
    }

    public function update()
    {
        $member = ModelsMembership::find($this->member_id);

        $newData = [
            'nama' => $this->nama,
            'email' => $this->email,
            'telp' => $this->telp,
            'diskon' => $this->diskon,
            'aktif' => $this->selectedAktif,
        ];

        $isChanged = $member->nama != $newData['nama'] ||
            $member->email != $newData['email'] ||
            $member->telp != $newData['telp'] ||
            $member->diskon != $newData['diskon'] ||
            $member->aktif != $newData['aktif'];

        if (!$isChanged) {
            session()->flash('status', 'Tidak ada perubahan yang dilakukan.');
            return $this->redirect('/membership', navigate: true);
        }

        $this->validate([
            'nama' => 'required',
            'email' => 'required|unique:memberships,email,' . $this->member_id,
            'telp' => 'required|unique:memberships,telp,' . $this->member_id . ',id|max:13',
            'diskon' => 'required|numeric|max:100',
        ]);

        $member->update($newData);

        session()->flash('status', 'Data Berhasil Diperbarui!');
        return $this->redirect('/membership', navigate: true);
    }

    public function clear()
    {
        $this->nama = '';
        $this->email = '';
        $this->telp = '';
        $this->diskon = '';
        $this->selectedAktif = '';
        $this->resetErrorBag();
        return $this->redirect('/membership', navigate: true);
    }

    public function deleteConfirmation($id)
    {
        $this->member_id = $id;
    }

    public function delete()
    {
        $id = $this->member_id;
        ModelsMembership::find($id)->delete();
        session()->flash('status', 'Data Berhasil Dihapus!');
        return $this->redirect('/membership', navigate: true);
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
            $member = ModelsMembership::where('nama', 'LIKE', '%' . $this->searchKey . '%')->orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        } else {
            $member = ModelsMembership::orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        }
        $this->countMembers = ModelsMembership::count();
        return view('livewire.membership', [
            'members' => $member,
        ]);
    }
}
