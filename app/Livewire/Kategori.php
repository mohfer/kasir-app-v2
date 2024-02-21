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
        if (!empty($id)) {
            $this->category_id = $id;
        }
    }

    public function delete()
    {
        // Hapus kategori berdasarkan category_id
        if (!empty($this->category_id)) {
            $categoryId = $this->category_id;

            // Perbarui category_id menjadi NULL untuk item yang terkait dengan kategori yang akan dihapus
            Item::where('category_id', $categoryId)->update(['category_id' => null]);

            // Hapus kategori
            Category::find($categoryId)->delete();
        }

        // Hapus beberapa kategori yang dipilih berdasarkan selectedCategoryId
        if (!empty($this->selectedCategoryId)) {
            foreach ($this->selectedCategoryId as $categoryId) {
                // Perbarui category_id menjadi NULL untuk item yang terkait dengan kategori yang akan dihapus
                Item::where('category_id', $categoryId)->update(['category_id' => null]);

                // Hapus kategori
                Category::find($categoryId)->delete();
            }
        }

        // Setelah penghapusan, beri pesan sukses dan arahkan kembali ke halaman kategori
        session()->flash('status', 'Data Berhasil Dihapus!');
        return redirect('/kategori');
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
