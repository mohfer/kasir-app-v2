<?php

namespace App\Livewire;

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

    #[Validate('required')]
    public $alamat;

    #[Validate('required|email|unique:suppliers')]
    public $email;

    #[Validate('required|max:16|unique:suppliers')]
    public $telp;

    public $title = 'Suppliers';
    public $supplier_id;
    public $selectedSupplierId = [];
    public $selectAll = false;
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

        $this->validate([
            'nama' => 'required|unique:suppliers,nama,' . $this->supplier_id,
            'email' => 'required|email|unique:suppliers,email,' . $this->supplier_id,
            'alamat' => 'required',
            'telp' => 'required|max:16|unique:suppliers,telp,' . $this->supplier_id,
        ]);

        if ($supplier->isDirty('nama', 'email', 'telp', 'alamat')) {
            $supplier->update([
                'nama' => $this->nama,
                'email' => $this->email,
                'alamat' => $this->alamat,
                'telp' => $this->telp,
            ]);

            session()->flash('status', 'Data Berhasil Diperbarui!');
        } else {
            session()->flash('status', 'Tidak ada perubahan yang dilakukan.');
        }
        return $this->redirect('/suppliers', navigate: true);
    }


    public function deleteConfirmation($id)
    {
        if (!empty($id)) {
            $this->supplier_id = $id;
        }
    }

    public function delete()
    {
        if (!empty($this->supplier_id)) {
            $id = $this->supplier_id;
            ModelsSupplier::find($id)->delete();
        }
        if (!empty($this->selectedSupplierId)) {
            for ($i = 0; $i < count($this->selectedSupplierId); $i++) {
                ModelsSupplier::find($this->selectedSupplierId[$i])->delete();
            }
        }
        session()->flash('status', 'Data Berhasil Dihapus!');
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

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedSupplierId = ModelsSupplier::pluck('id')->toArray();
        } else {
            $this->selectedSupplierId = [];
        }
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
