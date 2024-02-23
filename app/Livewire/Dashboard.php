<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Item;
use Livewire\Component;
use App\Models\Membership;
use App\Models\Transaction;

class Dashboard extends Component
{
    public $title = 'Dashboard';
    public $barang;
    public $membership;
    public $pendapatan;
    public $transaksi;

    public function mount()
    {
        $today = Carbon::today();
        $this->barang = Item::count();
        $this->membership = Membership::count() - 1;
        $this->pendapatan = number_format(Transaction::whereDate('created_at', $today)->sum('total'));
        $this->transaksi = Transaction::whereDate('created_at', $today)->count();
    }

    public function render()
    {
        $transactionHistories = Transaction::orderBy('created_at', 'desc')->limit(5)->get();
        view()->share('title', $this->title);
        return view('livewire.dashboard', [
            'transactionHistories' => $transactionHistories
        ]);
    }
}
