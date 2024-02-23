<div>
    <div class="wrapper">
        <div class="container">

            <div class="row gap-3 mt-3 justify-content-center">
                <div class="col-md-3 border shadow bg-danger text-light rounded p-3">
                    <div class="row">
                        <div class="col">
                            <h5>Barang Terjual</h5>
                        </div>
                        <div class="col">
                            <h1 class="text-center">{{ number_format($totalBarangTerjual) }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 border shadow bg-warning text-light rounded p-3">
                    <div class="row">
                        <div class="col">
                            <h5>Total Pendapatan</h5>
                        </div>
                        <div class="col">
                            <h1 class="text-center">{{ number_format($totalPendapatan) }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 border shadow bg-success text-light rounded p-3">
                    <div class="row">
                        <div class="col">
                            <h5>Total Transaksi</h5>
                        </div>
                        <div class="col">
                            <h1 class="text-center">{{ $totalTransaksi }}</h1>
                        </div>
                    </div>
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
