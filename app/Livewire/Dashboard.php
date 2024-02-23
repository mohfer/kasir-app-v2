<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Stock;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\Membership;
use App\Models\StokHistory;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $title = 'Dashboard';
    public $barang;
    public $membership;
    public $pendapatan;
    public $transaksi;
    public $stok;
    public $supplier;

    public function mount()
    {
        $today = Carbon::today();
        $this->barang = Item::count();
        $this->membership = Membership::count() - 1;
        $this->pendapatan = number_format(Transaction::whereDate('created_at', $today)->sum('total'));
        $this->transaksi = Transaction::whereDate('created_at', $today)->count();
        $sumStok = Stock::select(DB::raw('SUM(stok_gudang + stok_etalase) as total_stok'))->first();
        $this->stok = $sumStok->total_stok;
        $this->supplier = Supplier::count();
    }

    public function render()
    {
        $transactionHistories = Transaction::orderBy('created_at', 'desc')->limit(5)->get();
        $stockHistories = StokHistory::orderBy('created_at', 'desc')->limit(5)->get();
        view()->share('title', $this->title);
        return view('livewire.dashboard', [
            'transactionHistories' => $transactionHistories,
            'stockHistories' => $stockHistories
        ]);
    }
}
