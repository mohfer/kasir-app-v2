<?php

namespace App\Livewire;

use App\Models\StokHistory;
use Livewire\Component;
use App\Models\Supplier as ModelsSupplier;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class Supplier extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Validate('required|unique:suppliers')]
    public $nama;

    #[Validate('required|max:100')]
    public $alamat;

    #[Validate('required|email|unique:suppliers')]
    public $email;

    #[Validate('required|max:13|unique:suppliers')]
    public $telp;

    public $title = 'Suppliers';
    public $supplier_id;
    public $searchKey;
    public $countSuppliers;
    public $sortColumn = 'nama';
    public $sortDirection = 'asc';

    public function save()
    {
        $this->validate();

        ModelsSupplier::create($this->only(
            'nama',
            'email',
            'alamat',
            'telp'
        ));

        session()->flash('status', 'Data Berhasil Ditambah!');
        $this->clear();
    }

    public function edit($id)
    {
        $supplier = ModelsSupplier::find($id);
        $this->nama = $supplier->nama;
        $this->email = $supplier->email;
        $this->alamat = $supplier->alamat;
        $this->telp = $supplier->telp;

        $this->supplier_id = $id;
    }

    public function update()
    {
        $supplier = ModelsSupplier::find($this->supplier_id);

        $newData = [
            'nama' => $this->nama,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'telp' => $this->telp,
        ];

        $isChanged = $supplier->nama != $newData['nama'] ||
            $supplier->email != $newData['email'] ||
            $supplier->alamat != $newData['alamat'] ||
            $supplier->telp != $newData['telp'];

        if (!$isChanged) {
            session()->flash('status', 'Tidak ada perubahan yang dilakukan.');
            return $this->redirect('/suppliers', navigate: true);
        }

        $this->validate([
            'nama' => 'required|unique:suppliers,nama,' . $this->supplier_id,
            'email' => 'required|email|unique:suppliers,email,' . $this->supplier_id,
            'telp' => 'required|max:13|unique:suppliers,telp,' . $this->supplier_id,
            'alamat' => 'required|max:100',
        ]);

        $supplier->update($newData);

        session()->flash('status', 'Data Berhasil Diperbarui!');
        return $this->redirect('/suppliers', navigate: true);
    }



    public function deleteConfirmation($id)
    {
        $this->supplier_id = $id;
    }

    public function delete()
    {
        $id = $this->supplier_id;
        $supplierHasTransactions = StokHistory::where('supplier_id', $id)->exists();

        if ($supplierHasTransactions) {
            session()->flash('error', 'Data tidak dapat dihapus karena masih dibutuhkan di halaman riwayat stok.');
        } else {
            ModelsSupplier::find($id)->delete();
            session()->flash('status', 'Data Berhasil Dihapus!');
        }

        return $this->redirect('/suppliers', navigate: true);
    }

    public function updatingSearchKey()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->nama = '';
        $this->email = '';
        $this->alamat = '';
        $this->telp = '';
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
            $supplier = ModelsSupplier::where('nama', 'LIKE', '%' . $this->searchKey . '%')->orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        } else {
            $supplier = ModelsSupplier::orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        }
        $this->countSuppliers = ModelsSupplier::count();
        return view('livewire.supplier', [
            'suppliers' => $supplier,
        ]);
    }
}
