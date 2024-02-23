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
    public $topSellingItems;

    public function filter()
    {
        $this->totalBarangTerjual = TransactionDetail::whereBetween('tanggal', [$this->dateStart, $this->dateEnd])
            ->sum('qty');

        $this->totalPendapatan = Transaction::whereBetween('tanggal', [$this->dateStart, $this->dateEnd])
            ->sum('total');

        $this->totalTransaksi = Transaction::whereBetween('tanggal', [$this->dateStart, $this->dateEnd])
            ->count();

        $topSellingItems = TransactionDetail::select('item_id', DB::raw('SUM(qty) as total_qty'))
            ->whereBetween('tanggal', [$this->dateStart, $this->dateEnd]) // Sesuaikan dengan tanggal yang Anda inginkan
            ->groupBy('item_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $topSellingItemsWithData = [];
        foreach ($topSellingItems as $topSellingItem) {
            $item = Item::find($topSellingItem->item_id);
            if ($item) {
                $topSellingItemsWithData[] = [
                    'item_name' => $item->nama_barang,
                    'total_qty' => $topSellingItem->total_qty
                ];
            }
        }
        $this->topSellingItems = $topSellingItemsWithData;


        $this->transactions = Transaction::orderBy('created_at', 'desc')->get();
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
