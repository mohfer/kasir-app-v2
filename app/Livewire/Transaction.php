<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use App\Models\Membership;
use App\Models\Stock;
use App\Models\TransactionDetail;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction as ModelsTransaction;

class Transaction extends Component
{
    #[Validate('required|numeric|min:1')]
    public $qty;

    public $title = 'Transaction';
    public $searchKey;
    public $cartItems = [];
    public $cartItemsData = [];
    public $selectedMembership;
    public $discount;
    public $subtotal = 0;
    public $totalBayar;
    public $kembalian;
    public $totalSetelahDiskon;
    public $kode_transaksi;
    public $stockEtalase;

    public function mount()
    {
        $this->qty = collect();
        $this->selectedMembership;
        $firstMember = Membership::first();
        if ($firstMember) {
            $this->selectedMembership = $firstMember->id;
        }
        $this->discount = 0;
        $this->kembalian = 0;
        $this->kode_transaksi = 'TRX-' . time();
    }

    public function addToCart($itemId)
    {
        if (!in_array($itemId, $this->cartItems)) {
            $this->cartItems[] = $itemId;
            $this->getCartItems();
            $this->qty[$itemId] = 1;
        } else {
            session()->flash('error', 'Item sudah ada di dalam cart.');
        }
        $this->updateKembalian();
    }


    public function updateQty($itemId, $qty)
    {
        $item = Item::find($itemId);

        if (!$item) {
            session()->flash('error', 'Item tidak ditemukan.');
            return;
        }

        $this->stockEtalase = $item->stock->stok_etalase ?? 0;

        if (empty($qty) || $qty <= 0) {
            session()->flash('error', 'Quantity harus diisi dan harus lebih dari 0.');
        }

        if ($qty > $this->stockEtalase) {
            session()->flash('error', 'Quantity melebihi stok etalase.');
        }

        $this->qty[$itemId] = $qty;
        $this->updateKembalian();
    }



    public function removeFromCart($itemId)
    {
        $this->cartItems = array_diff($this->cartItems, [$itemId]);
        $this->qty->forget($itemId);
        $this->getCartItems();
    }

    public function getCartItems()
    {
        $this->cartItemsData = Item::whereIn('id', $this->cartItems)->get();
    }

    public function updatedSelectedMembership($value)
    {
        $selectedMembership = Membership::find($value);

        if ($selectedMembership) {
            $this->discount = $selectedMembership->diskon;
        } else {
            $this->discount = 0;
        }
        $this->updateKembalian();
    }

    public function calculateSubtotal()
    {
        $this->subtotal = 0;

        foreach ($this->cartItemsData as $cartItem) {
            $this->subtotal += $cartItem->harga_jual_akhir * $this->qty[$cartItem->id];
        }

        return number_format($this->subtotal);
    }

    public function calculateTotalSetelahDiskon()
    {
        if ($this->selectedMembership != 0 && $membership = Membership::find($this->selectedMembership)) {
            $discount = $membership->diskon;
            $this->totalSetelahDiskon = $this->subtotal * (1 - $discount / 100);
        } else {
            $this->totalSetelahDiskon = $this->subtotal;
        }

        $this->updateKembalian();

        return number_format($this->totalSetelahDiskon);
    }

    public function updatedTotalBayar()
    {
        $this->updateKembalian();
    }

    public function updateKembalian()
    {
        $totalSetelahDiskon = $this->totalSetelahDiskon;
        $totalBayar = $this->totalBayar;

        if ($totalBayar != '') {
            $kembalian = $totalBayar - $totalSetelahDiskon;
            if ($kembalian < 0) {
                $kembalian = 0;
            }
            $this->kembalian = $kembalian;
        } else {
            $this->kembalian = 0;
        }
    }

    public function bayar()
    {
        if ($this->totalBayar < $this->totalSetelahDiskon) {
            session()->flash('error', 'Total Bayar Kurang.');
            return;
        }

        foreach ($this->qty as $qtyItem) {
            if ($qtyItem > $this->stockEtalase) {
                session()->flash('error', 'Ada barang yang melebihi stok etalase.');
                return;
            }
        }


        // $this->validate([
        //     'totalBayar' => 'required|numeric|min:' . $this->totalSetelahDiskon,
        //     'qty' => 'required|numeric|min:1|max:' . $this->stockEtalase
        // ], [
        //     'totalBayar.required' => 'Total bayar harus diisi.',
        //     'totalBayar.min' => 'Total bayar harus lebih besar dari total harga.',
        // ]);


        DB::transaction(function () {
            ModelsTransaction::create([
                'kode_transaksi' => $this->kode_transaksi,
                'membership_id' => $this->selectedMembership,
                'user_id' => Auth::id(),
                'diskon' => $this->discount,
                'total' => $this->totalSetelahDiskon,
                'bayar' => $this->totalBayar,
                'kembalian' => $this->kembalian,
                'tanggal' => now()->toDateString(),
            ]);

            foreach ($this->cartItemsData as $item) {
                $stok = Stock::where('item_id', $item['id'])->first();

                if ($stok) {
                    $stok->update(['stok_etalase' => $stok->stok_etalase - $this->qty[$item['id']]]);
                } else {
                    session()->flash('success', 'Transaksi Gagal!');
                    return $this->redirect('/transaction', navigate: true);
                }
                TransactionDetail::create([
                    'transaction_id' => ModelsTransaction::latest()->first()->id,
                    'item_id' => $item['id'],
                    'qty' => $this->qty[$item['id']],
                    'subtotal' => $this->subtotal,
                    'tanggal' => now()->toDateString(),
                ]);
            }
        });

        session()->flash('success', 'Transaksi berhasil!');
        return $this->redirect('/transaction', navigate: true);
    }

    public function render()
    {
        $items = Item::whereHas('stock', function ($query) {
            $query->where('stok_etalase', '>', 0);
        });

        if ($this->searchKey) {
            $items->where('nama_barang', 'like', '%' . $this->searchKey . '%');
        }

        $items = $items->get();

        $memberships = Membership::where('aktif', 'Ya')->get();
        view()->share('title', $this->title);
        return view('livewire.transaction', [
            'items' => $items,
            'cartItemsData' => $this->cartItemsData,
            'memberships' => $memberships,
        ]);
    }
}
