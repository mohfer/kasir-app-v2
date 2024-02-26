<div>
    <div class="wrapper">
        <div class="container">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row mt-3">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-header fw-bold ">
                            List
                        </div>
                        <div class="container my-3">
                            <input type="text" class="form-control mb-3" placeholder="Search..."
                                wire:model.live='searchKey'>
                            <div class="row mb-3">
                                @if ($items->isEmpty())
                                    <p class="text-center mt-3">No Data</p>
                                @else
                                    @foreach ($items as $item)
                                        <div class="col-md-6 mb-3">
                                            <div class="card position-relative">
                                                <div
                                                    class="position-absolute top-0 start-0 bg-primary text-white px-2 py-1">
                                                    {{ $item->stock->stok_etalase }}
                                                </div>
                                                @if ($item->diskon)
                                                    <div
                                                        class="position-absolute top-0 end-0 bg-success text-white px-2 py-1">
                                                        {{ $item->diskon }}%
                                                    </div>
                                                @endif
                                                <img src="https://source.unsplash.com/random/500x500"
                                                    class="card-img-top" alt="Item">
                                                <div class="card-body text-center">
                                                    <h6 class="card-title">{{ $item->nama_barang }}</h6>
                                                    <h5 class="fw-bold">
                                                        Rp. {{ number_format($item->harga_jual_akhir) }}
                                                    </h5>
                                                    <button wire:click="addToCart({{ $item->id }})"
                                                        class="btn btn-outline-primary">Add To Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col text-start">
                                    <span class="fw-bold">Transaksi</span>
                                </div>
                            </div>
                        </div>
                        <div class="container my-3">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Barang</th>
                                        <th scope="col" class="text-center">Harga</th>
                                        <th scope="col" class="w-25 text-center">Qty</th>
                                        <th scope="col" class="w-25 text-center">Subtotal</th>
                                        <th scope="col" class="text-center"><i class="bi bi-trash"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $cartItemId)
                                        @php
                                            $cartItem = $cartItemsData->where('id', $cartItemId)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $cartItem->nama_barang }}</td>
                                            <td class="text-center">{{ number_format($cartItem->harga_jual_akhir) }}
                                            </td>
                                            <td class="d-flex justify-content-center align-items-center">
                                                <input type="number" class="form-control w-50"
                                                    value="{{ $qty[$cartItem->id] }}"
                                                    wire:change="updateQty({{ $cartItem->id }}, $event.target.value)"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </td>
                                            <td class="text-center">
                                                {{ number_format($cartItem->harga_jual_akhir * $qty[$cartItem->id]) }}
                                            </td>
                                            <td class="text-center">
                                                <button wire:click="removeFromCart({{ $cartItem->id }})"
                                                    class="btn btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                            </table>
                            <div class="fw-bold mb-3 fs-5">
                                <div class="row">
                                    <div class="col">
                                        <span>Subtotal:</span>
                                    </div>
                                    <div class="col text-end">
                                        {{ $this->calculateSubtotal() }}<br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <span>Diskon:</span>
                                    </div>
                                    <div class="col text-end">
                                        <span>
                                            {{ $discount }}%
                                        </span><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <span>Total:</span>
                                    </div>
                                    <div class="col text-end">
                                        <span>{{ $this->calculateTotalSetelahDiskon() }}</span><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <span>Kembali:</span>
                                    </div>
                                    <div class="col text-end">
                                        <span>
                                            <input type="text" class="form-control-plaintext fw-bold text-end"
                                                disabled value="{{ number_format($kembalian) }}">
                                        </span><br>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Kode Transaksi</label>
                                    <input type="text" class="form-control" wire:model.live="kode_transaksi"
                                        disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label class="form-label">Customer</label>
                                    <select class="form-select" wire:model.change="selectedMembership">
                                        @foreach ($memberships as $membership)
                                            <option value="{{ $membership->id }}">{{ $membership->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Bayar</label>
                                    <input type="number" class="form-control @error('totalBayar') is-invalid @enderror"
                                        wire:model.live='totalBayar'
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57" @if (count($cartItems) == 0)
                                    disabled
                                    @endif>
                                    @error('totalBayar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-primary w-100 mt-3" wire:click="bayar">Bayar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
