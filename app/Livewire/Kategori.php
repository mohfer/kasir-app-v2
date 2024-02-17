<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

class Kategori extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Validate('required|unique:categories')]
    public $nama_kategori;

    public $title = 'Kategori';
    public $category;
    public $category_id;
    public $searchKey;
    public $selectedCategoryId = [];
    public $selectAll = false;
    public $sortColumn = 'nama_kategori';
    public $sortDirection = 'asc';
    public $countCategories;

    public function save()
    {
        $this->validate();

        Category::create($this->only(
            'nama_kategori'
        ));

        session()->flash('status', 'Data Berhasil Ditambah!');
        $this->clear();
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $this->nama_kategori = $category->nama_kategori;

        $this->category_id = $id;
    }

    public function update()
    {
        $this->validate();

        Category::find($this->category_id)->update([
            'nama_kategori' => $this->nama_kategori,
        ]);

        session()->flash('status', 'Data Berhasil Diperbarui!');
        return $this->redirect('/kategori', navigate: true);
    }

    public function deleteConfirmation($id)
    {
        if ($id != '') {
            $this->category_id = $id;
        }
    }

    public function delete()
    {
        if ($this->category_id != '') {
            $id = $this->category_id;
            Category::find($id)->delete();
        }
        if (count($this->selectedCategoryId)) {
            for ($i = 0; $i < count($this->selectedCategoryId); $i++) {
                Category::find($this->selectedCategoryId[$i])->delete();
            }
        }
        session()->flash('status', 'Data Berhasil Dihapus!');
        return $this->redirect('/kategori', navigate: true);
    }

    public function updatingSearchKey()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->nama_kategori = '';
        $this->selectedCategoryId = [];
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
            $this->selectedCategoryId = Category::pluck('id')->toArray();
        } else {
            $this->selectedCategoryId = [];
        }
    }

    public function render()
    {
        view()->share('title', $this->title);
        if ($this->searchKey != null) {
            $category = Category::where('nama_kategori', 'LIKE', '%' . $this->searchKey . '%')->orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        } else {
            $category = Category::orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        }
        $this->countCategories = Category::count();
        return view('livewire.kategori', [
            'categories' => $category,
        ]);
    }
}
