<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use App\Models\Membership;

class Transaction extends Component
{

    public $searchKey;
    public $cartItems = [];
    public $cartItemsData = [];
    public $qty;
    public $selectedMembership = 0;
    public $discount;
    public $subtotal = 0;
    public $totalBayar;
    public $kembalian;
    public $totalSetelahDiskon;
    public $kode_transaksi;

    public function mount()
    {
        $this->qty = collect();
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
            $this->calculateTotalSetelahDiskon();
            $this->updateKembalian();
        } else {
            $this->qty[$itemId] += 1;
        }
    }

    public function updateQty($itemId, $qty)
    {
        $this->qty[$itemId] = $qty;
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
        $subtotal = $this->subtotal;

        if ($this->selectedMembership != 0) {
            $membership = Membership::find($this->selectedMembership);
            if ($membership) {
                $diskon = $membership->diskon;
                $totalSetelahDiskon = $subtotal * (1 - $diskon / 100);
                if ($this->totalBayar != '') {
                    $this->kembalian = $this->totalBayar - $totalSetelahDiskon;
                }
            }
        } else {
            if ($this->totalBayar != '') {
                $this->kembalian = $this->totalBayar - $this->subtotal;
            } else {
                $this->kembalian = 0;
            }
        }
        if ($this->kembalian < 0) {
            $this->kembalian = 0;
        }
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

        $memberships = Membership::where('aktif', 'Aktif')->get();

        return view('livewire.transaction', [
            'items' => $items,
            'cartItemsData' => $this->cartItemsData,
            'memberships' => $memberships,
        ]);
    }
}
