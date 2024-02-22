<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Stock;
use App\Models\StokHistory;
use Livewire\Component;
use App\Models\Supplier;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;

class StokGudang extends Component
{

    #[Validate('required|unique:stok_histories')]
    public $no_faktur;

    #[Validate('required')]
    public $jumlah_item, $bayar;

    public $title = 'Stok Gudang';
    public $harga;
    public $kembali;
    public $selectedItemId;
    public $selectedSupplierId;
    public $sortColumn = 'item_id';
    public $sortDirection = 'asc';
    public $countStocks;
    public $errorMessage;

    public function mount()
    {
        $this->jumlah_item = 0;
        $this->bayar = 0;
        $this->harga = 0;
        $this->kembali = 0;

        $firstItem = Item::first();
        if ($firstItem) {
            $this->selectedItemId = $firstItem->id;
        }

        $firstSupplier = Supplier::first();
        if ($firstSupplier) {
            $this->selectedSupplierId = $firstSupplier->id;
        }
    }

    public function updatedSelectedItemId($value)
    {
        $this->updateHarga();
        $this->updateKembali();
    }

    public function updatedJumlahItem($value)
    {
        $this->updateHarga();
        $this->updateKembali();
    }

    public function updateHarga()
    {
        if ($this->selectedItemId && $this->jumlah_item != '') {
            $barang = Item::find($this->selectedItemId);
            $this->harga = $barang->harga_beli * $this->jumlah_item;
        } else {
            $this->harga = 0;
        }
    }

    public function updatedBayar($value)
    {
        if ($this->bayar < $this->harga) {
            $this->addError('bayar', 'The payment amount must be greater than or equal to the price.');
        }
        $this->updateKembali();
    }

    public function updateKembali()
    {
        if ($this->bayar != '') {
            $this->kembali = $this->bayar - $this->harga;
        }
    }

    public function save()
    {
        if ($this->selectedSupplierId == '' || $this->selectedItemId == '') {
            $this->errorMessage = 'Pilih Barang dan Supplier terlebih dahulu';
            return;
        } else {
            $this->validate([
                'bayar' => 'required|numeric|min:' . $this->harga,
                'jumlah_item' => 'required|numeric|min:1',
            ]);
            $this->validate();
            DB::transaction(function () {

                $newStock = Stock::updateOrCreate(
                    ['item_id' => $this->selectedItemId],
                    ['stok_gudang' => DB::raw('stok_gudang + ' . $this->jumlah_item)]
                );

                // Buat entri baru dalam StokHistory
                StokHistory::create([
                    'no_faktur' => $this->no_faktur,
                    'item_id' => $this->selectedItemId,
                    'supplier_id' => $this->selectedSupplierId,
                    'jumlah' => $this->jumlah_item,
                    'harga' => $this->harga,
                    'bayar' => $this->bayar,
                    'kembali' => $this->kembali,
                    'keterangan' => 'Gudang',
                ]);
                // Buat entri baru di tabel Item dengan stock_id yang sesuai
                $item = Item::find($this->selectedItemId);
                if ($item) {
                    $item->update([
                        'stock_id' => $newStock->id,
                    ]);
                }
            });
            session()->flash('status', 'Data Berhasil Ditambah!');
            return $this->redirect('/stok-gudang', navigate: true);
        }
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }

    public function clear()
    {
        $this->no_faktur = '';
        $this->selectedItemId = '';
        $this->selectedSupplierId = '';
        $this->jumlah_item = 0;
        $this->harga = 0;
        $this->bayar = 0;
        $this->kembali = 0;
        $this->resetErrorBag();
    }

    public function render()
    {
        view()->share('title', $this->title);
        $item = Item::orderBy('nama_barang', 'asc')->select('id', 'nama_barang')->get();
        $supplier = Supplier::orderBy('nama', 'asc')->select('id', 'nama')->get();
        $stocks = Stock::orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        $this->countStocks = Stock::count();
        return view('livewire.stok-gudang', [
            'items' => $item,
            'suppliers' => $supplier,
            'stocks' => $stocks,
        ]);
    }
}
