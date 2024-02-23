<div>
    <div class="wrapper">
        <div class="container">

            {{-- Alert --}}
            @if (session()->has('status'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col">

                    {{-- Trigger Modal Tambah --}}
                    <div class="text-end mb-3">
                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                            data-bs-target="#modalTambah">
                            Tambah {{ $title }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- Data --}}
            <div class="card">
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
                    @if ($stocks->isEmpty())
                        <p class="text-center mt-3">No Data</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col" wire:click="sort('item_id')">Barang
                                            <span class="float-end" style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'item_id' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'item_id' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span>
                                        </th>
                                        <th scope="col" wire:click="sort('stok_gudang')">Stok <span class="float-end"
                                                style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'stok_gudang' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'stok_gudang' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span></th>
                                        <th scope="col" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stocks as $key => $stock)
                                        <tr>
                                            <td>{{ $stocks->firstItem() + $key }}</td>
                                            <td>{{ $stock->item->nama_barang }}</td>
                                            <td>{{ $stock->stok_gudang }}</td>
                                            @if ($stock->stok_gudang <= 5)
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-warning"
                                                        data-bs-toggle="modal" data-bs-target="#modalTambah">
                                                        Tambah Stok
                                                    </button>
                                                </td>
                                            @else
                                                <td class="text-center">
                                                    <button class="btn btn-success">Tersedia</button>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col">
                                {{ $stocks->links() }}
                            </div>
                            <div class="col mt-2 text-end">
                                Jumlah Data: <span class="fw-bold">{{ $countStocks }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Modal Tambah --}}
            <div wire:ignore.self class="modal fade" id="modalTambah" data-bs-backdrop="static" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah
                                {{ $title }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                wire:click='clear()'></button>
                        </div>
                        <div class="modal-body">
                            @if ($errorMessage)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ $errorMessage }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form wire:submit.prevent='save'>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomor
                                        Faktur</label>
                                    <input type="number" class="form-control @error('no_faktur') is-invalid @enderror"
                                        wire:model.live='no_faktur'
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    @error('no_faktur')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Barang</label>
                                    <select class="form-select" wire:model.change="selectedItemId">
                                        @if ($items->isEmpty())
                                            <option>Data tidak ditemukan</option>
                                        @else
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_barang }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Supplier</label>
                                    <select class="form-select" wire:model.change="selectedSupplierId">
                                        @if ($suppliers->isEmpty())
                                            <option>Data tidak ditemukan</option>
                                        @else
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->nama }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jumlah</label>
                                            <input type="number"
                                                class="form-control @error('jumlah_item') is-invalid @enderror"
                                                wire:model.live='jumlah_item'
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            @error('jumlah_item')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Harga</label>
                                            <input type="number"
                                                class="form-control @error('harga') is-invalid @enderror"
                                                wire:model.live='harga' disabled>
                                            @error('harga')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Bayar</label>
                                            <input type="number"
                                                class="form-control @error('bayar') is-invalid @enderror"
                                                wire:model.live='bayar'
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            @error('bayar')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kembali</label>
                                            <input type="number"
                                                class="form-control @error('kembali') is-invalid @enderror"
                                                wire:model.live='kembali' disabled>
                                            @error('kembali')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                        wire:click='clear()'>Close</button>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
