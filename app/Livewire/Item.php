<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\Item as ModelsItem;
use Illuminate\Support\Facades\Storage;

class Item extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Validate('required|unique:items')]
    public $kode_barang, $nama_barang;

    #[Validate('required|numeric|min:1')]
    public $selectedCategory, $harga_beli, $harga_jual_awal;

    #[Validate('required|numeric|max:100|min:0')]
    public $diskon;

    #[Validate('nullable|image|max:2048')]
    public $photo;

    public $title = 'Items';
    public $item_id;
    public $harga_jual_akhir;
    public $sortColumn = 'nama_barang';
    public $sortDirection = 'asc';
    public $countItems;
    public $searchKey;
    public $errorMessage;
    public $fileName;
    public $newFileName;
    public $foto;

    public function mount()
    {
        $this->harga_beli = 0;
        $this->diskon = 0;
        $this->harga_jual_awal = 0;
        $this->hitungHargaJualAkhir();
        $this->generateKodeItem();

        $firstCategory = Category::first();
        if ($firstCategory) {
            $this->selectedCategory = $firstCategory->id;
        }
    }


    public function generateKodeItem()
    {
        $length = 12;
        $min = pow(12, ($length - 1));
        $max = pow(12, $length) - 1;
        $randomNumbers = mt_rand($min, $max);
        $this->kode_barang = $randomNumbers;
    }

    public function updated($field)
    {
        if ($field === 'harga_jual_awal' || $field === 'diskon') {
            $this->hitungHargaJualAkhir();
        }
    }

    private function hitungHargaJualAkhir()
    {
        if ($this->harga_jual_awal != '') {
            $diskon_decimal = $this->diskon ? $this->diskon / 100 : 0;
            $jumlah_diskon = $this->harga_jual_awal * $diskon_decimal;
            $this->harga_jual_akhir = $this->harga_jual_awal - $jumlah_diskon;
        }
    }

    public function save()
    {
        if ($this->selectedCategory == '') {
            $this->errorMessage = 'Pilih kategori terlebih dahulu';
            return;
        } else {
            $this->validate();

            $this->validate([
                'photo' => 'nullable|image|max:2048',
            ]);

            $newFileName = md5($this->photo . microtime()) . '.' . $this->photo->extension();
            $this->photo->storeAs('items', $newFileName);

            ModelsItem::create([
                'kode_barang' => $this->kode_barang,
                'nama_barang' => $this->nama_barang,
                'category_id' => $this->selectedCategory,
                'harga_beli' => $this->harga_beli,
                'harga_jual_awal' => $this->harga_jual_awal,
                'diskon' => $this->diskon ?? 0,
                'harga_jual_akhir' => $this->harga_jual_akhir,
                'foto' => $newFileName,
            ]);

            session()->flash('status', 'Data Berhasil Ditambah!');
            $this->clear();
        }
    }

    public function edit($id)
    {
        $item = ModelsItem::find($id);
        $this->kode_barang = $item->kode_barang;
        $this->nama_barang = $item->nama_barang;

        $firstCategory = Category::first();
        if ($firstCategory) {
            $this->selectedCategory = $firstCategory->id;
        } else {
            $this->selectedCategory = $item->category_id;
        }
        $this->harga_beli = $item->harga_beli;
        $this->harga_jual_awal = $item->harga_jual_awal;
        $this->diskon = $item->diskon;
        $this->harga_jual_akhir = $item->harga_jual_akhir;
        $this->foto = $item->foto;

        $this->item_id = $id;
    }

    public function update()
    {
        $this->validate([
            'photo' => 'nullable|image|max:2048',
        ]);

        $item = ModelsItem::find($this->item_id);

        $newFileName = null;

        if ($this->photo) {
            $newFileName = md5($this->photo . microtime()) . '.' . $this->photo->extension();
            $this->photo->storeAs('items', $newFileName);

            if ($item->foto) {
                Storage::delete('items/' . $item->foto);
            }
        }

        $newData = [
            'nama_barang' => $this->nama_barang,
            'category_id' => $this->selectedCategory,
            'harga_beli' => $this->harga_beli,
            'harga_jual_awal' => $this->harga_jual_awal,
            'diskon' => $this->diskon == '' ? 0 : $this->diskon,
            'harga_jual_akhir' => $this->harga_jual_akhir,
        ];

        if ($newFileName) {
            $newData['foto'] = $newFileName;
        }

        $isChanged = $item->nama_barang != $newData['nama_barang'] ||
            $item->category_id != $newData['category_id'] ||
            $item->harga_beli != $newData['harga_beli'] ||
            $item->harga_jual_awal != $newData['harga_jual_awal'] ||
            $item->diskon != $newData['diskon'] ||
            $item->harga_jual_akhir != $newData['harga_jual_akhir'];

        if (isset($newData['foto'])) {
            $isChanged = $isChanged || $item->foto != $newData['foto'];
        }

        if (!$isChanged) {
            session()->flash('status', 'Tidak ada perubahan yang dilakukan.');
            return $this->redirect('/items', navigate: true);
        }

        $this->validate([
            'nama_barang' => 'required|unique:items,nama_barang,' . $this->item_id,
            'selectedCategory' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'harga_jual_awal' => 'required|numeric',
            'diskon' => 'required|numeric|max:100',
        ]);

        $item->update($newData);

        session()->flash('status', 'Data Berhasil Diperbarui!');
        return $this->redirect('/items', navigate: true);
    }

    public function deleteConfirmation($id)
    {
        $this->item_id = $id;
    }

    public function delete()
    {
        $id = $this->item_id;
        ModelsItem::find($id)->delete();
        session()->flash('status', 'Data Berhasil Dihapus!');
        return $this->redirect('/items', navigate: true);
    }

    public function clear()
    {
        $this->kode_barang = '';
        $this->nama_barang = '';
        $this->selectedCategory = '';
        $this->harga_beli = 0;
        $this->harga_jual_awal = 0;
        $this->diskon = 0;
        $this->harga_jual_akhir = 0;
        $this->resetErrorBag();
        return $this->redirect('/items', navigate: true);
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        view()->share('title', $this->title);
        $categories = Category::orderBy('nama_kategori', 'asc')->select('id', 'nama_kategori')->get();
        if ($this->searchKey != null) {
            $items = ModelsItem::where('nama_barang', 'LIKE', '%' . $this->searchKey . '%')->orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        } else {
            $items = ModelsItem::orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        }
        $this->countItems = ModelsItem::count();
        return view('livewire.item', [
            'categories' => $categories,
            'items' => $items,
        ]);
    }
}
