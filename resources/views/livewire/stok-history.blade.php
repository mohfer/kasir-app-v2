<div>
    <div class="wrapper">
        <div class="container">
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="" class="form-label">Date Start</label>
                    <input type="date" class="form-control" wire:model.change="dateStart">
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label">Date End</label>
                    <input type="date" class="form-control" wire:model.change="dateEnd">
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label">Keterangan</label>
                    <select class="form-select" wire:model.change="keteranganSelected">
                        <option value="All">All</option>
                        <option value="Ditambahkan Ke Gudang">Ditambahkan Ke Gudang</option>
                        <option value="Dipindahkan Ke Etalase">Dipindahkan Ke Etalase</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label"></label>
                    <a class="btn btn-primary w-100" href="{{ url('riwayat-stok') }}" wire:navigate>Reset</a>
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
                    @if ($stockHistories->isEmpty())
                        <p class="text-center mt-3">No Data</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">No Faktur</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Barang</th>
                                        <th scope="col">Supplier</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Bayar</th>
                                        <th scope="col">Kembali</th>
                                        <th scope="col">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stockHistories as $key => $stockHistory)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $stockHistory->no_faktur }}</td>
                                            <td>{{ $stockHistory->created_at }}</td>
                                            <td>{{ $stockHistory->item->nama_barang }}</td>
                                            <td>{{ optional($stockHistory->supplier)->nama }}</td>
                                            <td>{{ number_format($stockHistory->jumlah) }}</td>
                                            <td>{{ number_format($stockHistory->harga) }}</td>
                                            <td>{{ number_format($stockHistory->bayar) }}</td>
                                            <td>{{ number_format($stockHistory->kembali) }}</td>
                                            <td>{{ $stockHistory->keterangan }}</td>
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
