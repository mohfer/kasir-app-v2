<?php

namespace App\Livewire;

use App\Models\Stock;
use Livewire\Component;
use Livewire\Attributes\Validate;

class StokEtalase extends Component
{
    #[Validate('required|numeric|min:0')]
    public $jumlah_item_etalase;

    public $title = 'Stok Etalase';
    public $selectedStockId;
    public $jumlah_item_gudang;
    public $sortColumn = 'id';
    public $sortDirection = 'asc';
    public $countStocks;

    public function mount()
    {
        $this->jumlah_item_etalase = 0;
        $firstItem = Stock::first();
        if ($firstItem) {
            $this->selectedStockId = $firstItem->id;
        }
    }

    public function updatedSelectedStockId($value)
    {
        $stock = Stock::find($value);
        $this->jumlah_item_gudang = $stock->stok_gudang;
    }

    public function updatedJumlahItemEtalase($value)
    {
        $this->updateJumlahItemGudang();
    }

    public function updateJumlahItemGudang()
    {
        $stock = Stock::find($this->selectedStockId);
        if ($stock) {
            $this->jumlah_item_gudang = $stock->stok_gudang;
        }
    }

    public function save()
    {
        $this->validate();

        $stockInWarehouse = Stock::find($this->selectedStockId);

        if ($this->jumlah_item_etalase == 0) {
            session()->flash('status', 'Tidak ada yang dipindahkan.');
            return $this->redirect('/stok-etalase', navigate: true);
        }

        if ($stockInWarehouse && $this->jumlah_item_etalase > $stockInWarehouse->stok_gudang) {
            $this->addError('jumlah_item_etalase', 'Jumlah item di etalase tidak boleh melebihi stok di gudang');
            return;
        }

        $stock = Stock::find($this->selectedStockId);
        $newEtalaseStock = $stock->stok_etalase + $this->jumlah_item_etalase;
        $stock->stok_gudang -= $this->jumlah_item_etalase;
        $stock->stok_etalase = $newEtalaseStock;
        $stock->save();

        session()->flash('status', 'Data Berhasil Ditambah!');
        return $this->redirect('/stok-etalase', navigate: true);
        $this->clear();
    }


    public function clear()
    {
        $this->selectedStockId = '';
        $this->jumlah_item_etalase = 0;
        $this->resetErrorBag();
    }


    public function render()
    {
        view()->share('title', $this->title);
        $stocks = Stock::orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        $this->countStocks = Stock::count();
        return view('livewire.stok-etalase', [
            'stocks' => $stocks,
        ]);
    }
}
