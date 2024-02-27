<div>
    <div class="wrapper">
        <div class="container">

            <div class="row gap-3 mt-3 justify-content-center">
                <div class="col-md-3 border shadow bg-danger text-light rounded p-3">
                    <h5>Barang Terjual</h5>
                    <h1 class="text-center">{{ number_format($totalBarangTerjual) }}</h1>
                </div>
                <div class="col-md-3 border shadow bg-warning text-light rounded p-3">
                    <h5>Total Pendapatan</h5>
                    <h1 class="text-center">Rp. {{ number_format($totalPendapatan) }}</h1>
                </div>
                <div class="col-md-3 border shadow bg-success text-light rounded p-3">
                    <h5>Total Transaksi</h5>
                    <h1 class="text-center">{{ $totalTransaksi }}</h1>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="" class="form-label">Date Start</label>
                    <input type="date" class="form-control" wire:model.change="dateStart">
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Date End</label>
                    <input type="date" class="form-control" wire:model.change="dateEnd">
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label"></label>
                    <a class="btn btn-primary w-100" href="{{ url('report') }}" wire:navigate>Reset</a>
                </div>
            </div>

            {{-- Data --}}
            <div class="card mt-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="fw-bold">{{ $title }}</h4>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Search..." autofocus
                                wire:model.live='searchKey'>
                        </div>
                    </div>
                </div>
                <div class="container">
                    @if ($transactions->isEmpty())
                        <p class="text-center mt-3">No Data</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kode Transakasi</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Kasir</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Diskon</th>
                                        <th scope="col">Bayar</th>
                                        <th scope="col">Kembalian</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $key => $transaction)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $transaction->kode_transaksi }}</td>
                                            <td>{{ $transaction->created_at }}</td>
                                            <td>{{ $transaction->membership->nama }}</td>
                                            <td>{{ $transaction->user->nama }}</td>
                                            <td>{{ number_format($transaction->total) }}</td>
                                            <td>{{ $transaction->diskon }}</td>
                                            <td>{{ number_format($transaction->bayar) }}</td>
                                            <td>{{ number_format($transaction->kembalian) }}</td>
                                            <td class="text-center"><button class="btn btn-warning"
                                                    data-bs-toggle="modal" data-bs-target="#modalUpdate"
                                                    wire:click='edit({{ $transaction->id }})'>Detail</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Detail Transaction --}}
            <div wire:ignore.self class="modal fade" id="modalUpdate" data-bs-backdrop="static" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Transaction</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                wire:click='clear()'></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <table class=" w-100">
                                    <tr>
                                        <td>Waktu</td>
                                        <td></td>
                                        <td class="text-end">{{ $waktu }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kode Transaksi</td>
                                        <td></td>
                                        <td class="text-end">{{ $kode_transaksi }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kasir</td>
                                        <td></td>
                                        <td class="text-end">{{ $kasir }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pt-3">Item</td>
                                        <td class="pt-3">Qty</td>
                                        <td class="pt-3 text-end">Subtotal</td>
                                    </tr>
                                    @if ($transactionDetails)
                                        @foreach ($transactionDetails as $detail)
                                            <tr>
                                                <td>{{ $detail->item->nama_barang }}</td>
                                                <td>{{ $detail->qty }}</td>
                                                <td class="text-end">
                                                    Rp.
                                                    {{ number_format($detail->qty * $detail->item->harga_jual_akhir) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">Tidak ada detail transaksi</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="pt-3">Subtotal</td>
                                        <td class="pt-3"></td>
                                        @if ($transactionDetails !== null && $transactionDetails->isNotEmpty())
                                            <td class="pt-3 text-end">Rp.
                                                {{ number_format($transactionDetails->first()->subtotal) }}
                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Customer</td>
                                        <td></td>
                                        @if ($transactionDetails !== null && $transactionDetails->isNotEmpty())
                                            <td class="text-end">{{ $customer }}
                                        @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Diskon</td>
                                        <td></td>
                                        @if ($transactionDetails !== null && $transactionDetails->isNotEmpty())
                                            <td class="text-end">{{ $diskon }}%
                                        @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td></td>
                                        @if ($transactionDetails !== null && $transactionDetails->isNotEmpty())
                                            <td class="text-end">Rp. {{ number_format($total) }}
                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Bayar</td>
                                        <td></td>
                                        @if ($transactionDetails !== null && $transactionDetails->isNotEmpty())
                                            <td class="text-end">Rp. {{ number_format($bayar) }}
                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Kembalian</td>
                                        <td></td>
                                        @if ($transactionDetails !== null && $transactionDetails->isNotEmpty())
                                            <td class="text-end">Rp. {{ number_format($kembalian) }}
                                            </td>
                                        @endif
                                    </tr>
                                </table>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    wire:click='clear()'>Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
