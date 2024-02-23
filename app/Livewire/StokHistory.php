<?php

namespace App\Livewire;

use App\Models\StokHistory as ModelsStokHistory;
use Livewire\Component;

class StokHistory extends Component
{
    public $title = 'Riwayat Stok';

    public $stockHistories;
    public $dateStart;
    public $dateEnd;
    public $keteranganSelected;
    public $searchKey;

    public function mount()
    {
        $this->keteranganSelected = 'All';
    }

    public function filter()
    {
        $query = ModelsStokHistory::query();

        if ($this->keteranganSelected === "All") {
            if ($this->dateStart && $this->dateEnd) {
                $this->stockHistories = $query->whereBetween('tanggal', [$this->dateStart, $this->dateEnd])
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $this->stockHistories = $query->orderBy('created_at', 'desc')->get();
            }
        } else {
            if ($this->dateStart && $this->dateEnd) {
                $query->whereBetween('tanggal', [$this->dateStart, $this->dateEnd]);
            }

            if ($this->keteranganSelected) {
                $query->where('keterangan', 'like', '%' . $this->keteranganSelected . '%');
            }
            $this->stockHistories = $query->orderBy('created_at', 'desc')->get();
        }
    }

    public function render()
    {
        if ($this->searchKey != null) {
            $this->stockHistories = ModelsStokHistory::where('no_faktur', 'LIKE', '%' . $this->searchKey . '%')->orderBy('created_at', 'desc')->get();
        } else {
            $this->filter();
        }

        view()->share('title', $this->title);
        // $stockHistories = ModelsStokHistory::orderBy('tanggal', 'desc')->get();
        return view('livewire.stok-history', [
            'stockHistories' => $this->stockHistories
        ]);
    }
}
