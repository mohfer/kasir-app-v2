<div>
    <div class="wrapper">
        <div class="container">
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @can('isKasir')
                <h1 class="text-center mt-3">Dashboard</h1>
                <div class="row gap-3 mt-3 justify-content-center">
                    <div class="col-md-3 border shadow bg-warning text-light rounded p-3">
                        <div class="row">
                            <div class="col">
                                <h5>Membership</h5>
                            </div>
                            <div class="col">
                                <h1 class="text-center">{{ $membership }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 border shadow bg-success text-light rounded p-3">
                        <div class="row">
                            <div class="col">
                                <h5>Pendapatan Hari Ini</h5>
                            </div>
                            <div class="col">
                                <h1 class="text-center">Rp. {{ $pendapatan }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 border shadow bg-primary text-light rounded p-3">
                        <div class="row">
                            <div class="col">
                                <h5>Transaksi Hari Ini</h5>
                            </div>
                            <div class="col">
                                <h1 class="text-center">{{ $transaksi }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <span class="fw-bold">{{ count($transactionHistories) }} Transaksi Terakhir</span>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        @if ($transactionHistories->isEmpty())
                            <p class="text-center mt-3">No Data</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-3">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Kode Transakasi</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Bayar</th>
                                            <th scope="col">Kembalian</th>
                                            <th scope="col">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactionHistories as $key => $transactionHistory)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $transactionHistory->kode_transaksi }}</td>
                                                <td>{{ number_format($transactionHistory->total) }}</td>
                                                <td>{{ number_format($transactionHistory->bayar) }}</td>
                                                <td>{{ number_format($transactionHistory->kembalian) }}</td>
                                                <td>{{ $transactionHistory->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endcan
    </div>
</div>
