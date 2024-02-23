<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class Report extends Component
{

    public $title = 'Report';
    public $transactions;
    public $dateStart;
    public $dateEnd;
    public $searchKey;
    public $totalBarangTerjual;
    public $totalPendapatan;
    public $totalTransaksi;

    public function filter()
    {
        if ($this->dateStart && $this->dateEnd) {
            $this->totalBarangTerjual = TransactionDetail::whereBetween('tanggal', [$this->dateStart, $this->dateEnd])->sum('qty');
            $this->totalPendapatan = Transaction::whereBetween('tanggal', [$this->dateStart, $this->dateEnd])->sum('total');
            $this->totalTransaksi = Transaction::whereBetween('tanggal', [$this->dateStart, $this->dateEnd])->count();
            $this->transactions = Transaction::whereBetween('tanggal', [$this->dateStart, $this->dateEnd])->orderBy('created_at', 'desc')->get();
        } else {
            $this->totalBarangTerjual = TransactionDetail::sum('qty');
            $this->totalPendapatan = Transaction::sum('total');
            $this->totalTransaksi = Transaction::count();
            $this->transactions = Transaction::orderBy('created_at', 'desc')->get();
        }
    }


    public function render()
    {
        if ($this->searchKey != null) {
            $this->transactions = Transaction::where('kode_transaksi', 'LIKE', '%' . $this->searchKey . '%')->orderBy('created_at', 'desc')->get();
        } else {
            $this->filter();
        }

        view()->share('title', $this->title);
        return view('livewire.report', [
            'transactions' => $this->transactions,
            'totalBarangTerjual' => $this->totalBarangTerjual,
            'totalPendapatan' => $this->totalPendapatan,
            'totalTransaksi' => $this->totalTransaksi
        ]);
    }
}
