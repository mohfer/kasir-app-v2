<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class Kategori extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Validate('required|unique:categories')]
    public $nama_kategori;

    public $title = 'Kategori';
    public $category_id;
    public $searchKey;
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
        $category = Category::find($this->category_id);

        $this->validate([
            'nama_kategori' => 'required|unique:categories,nama_kategori,' . $this->category_id,
        ]);

        if ($category->isDirty('nama_kategori')) {
            $category->update([
                'nama_kategori' => $this->nama_kategori,
            ]);

            session()->flash('status', 'Data Berhasil Diperbarui!');
        } else {
            session()->flash('status', 'Tidak ada perubahan yang dilakukan.');
        }

        return $this->redirect('/kategori', navigate: true);
    }



    public function deleteConfirmation($id)
    {
        $this->category_id = $id;
    }

    public function delete()
    {
        $categoryId = $this->category_id;
        Item::where('category_id', $categoryId)->update(['category_id' => null]);
        Category::find($categoryId)->delete();
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
