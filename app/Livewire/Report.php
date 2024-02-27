<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class Report extends Component
{

    public $title = 'Report';
    public $transaction;
    public $waktu;
    public $kode_transaksi;
    public $kasir;
    public $subtotal;
    public $customer;
    public $diskon;
    public $total;
    public $bayar;
    public $kembalian;
    public $transactionDetails;
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

    public function edit($id)
    {
        $this->transaction = Transaction::findOrFail($id);
        $this->transactionDetails = TransactionDetail::where('transaction_id', $id)->get();
        $this->waktu = $this->transaction->created_at;
        $this->kode_transaksi = $this->transaction->kode_transaksi;
        $this->kasir = $this->transaction->user->nama;
        $this->customer = $this->transaction->membership->nama;
        $this->diskon = $this->transaction->diskon;
        $this->total = $this->transaction->total;
        $this->bayar = $this->transaction->bayar;
        $this->kembalian = $this->transaction->kembalian;
    }

    public function clear()
    {
        $this->kode_transaksi == '';
        $this->kasir == '';
        $this->customer == '';
        $this->diskon == '';
        $this->total == '';
        $this->bayar == '';
        $this->kembalian == '';
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
            'totalTransaksi' => $this->totalTransaksi,
            'transactionDetails' => $this->transactionDetails,
        ]);
    }
}
