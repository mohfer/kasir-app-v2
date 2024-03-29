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
                    @if ($items->isEmpty())
                        <p class="text-center mt-3">No Data</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col" wire:click="sort('kode_barang')">Kode Barang
                                            <span class="float-end" style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'kode_barang' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'kode_barang' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span>
                                        </th>
                                        <th scope="col" wire:click="sort('nama_barang')">Nama Barang <span
                                                class="float-end" style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'nama_barang' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'nama_barang' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span></th>
                                        <th scope="col" wire:click="sort('category_id')">Category <span
                                                class="float-end" style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'category_id' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'category_id' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span></th>
                                        <th scope="col" wire:click="sort('harga_beli')">Harga Beli <span
                                                class="float-end" style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'harga_beli' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'harga_beli' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span></th>
                                        <th scope="col" wire:click="sort('harga_jual_akhir')">Harga Jual <span
                                                class="float-end" style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'harga_jual_akhir' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'harga_jual_akhir' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span></th>
                                        <th scope="col">Stok</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $key => $item)
                                        <tr>
                                            <td>{{ $items->firstItem() + $key }}</td>
                                            <td>{{ $item->kode_barang }}</td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>
                                                @isset($item->category)
                                                    {{ $item->category->nama_kategori }}
                                                @endisset
                                            </td>
                                            <td>{{ number_format($item->harga_beli) }}</td>
                                            <td>{{ number_format($item->harga_jual_akhir) }}</td>
                                            <td>
                                                @isset($item->stock)
                                                    {{ $item->stock->stok_gudang + $item->stock->stok_etalase }}
                                                @endisset
                                            </td>
                                            <td class="text-center"><button class="btn btn-warning"
                                                    data-bs-toggle="modal" data-bs-target="#modalUpdate"
                                                    wire:click='edit({{ $item->id }})'>Detail</button>
                                                {{-- <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#modalDelete"
                                                    wire:click='deleteConfirmation({{ $item->id }})'>Delete</button> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col">
                                {{ $items->links() }}
                            </div>
                            <div class="col mt-2 text-end">
                                Jumlah Data: <span class="fw-bold">{{ $countItems }}</span>
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
                                <div class="alert alert-danger">{{ $errorMessage }}</div>
                            @endif
                            <form wire:submit.prevent='save'>
                                <div class="mb-3">
                                    <label for="" class="form-label">Kode
                                        {{ $title }}</label>
                                    <input type="text"
                                        class="form-control @error('kode_barang') is-invalid @enderror"
                                        wire:model.live='kode_barang' disabled>
                                    @error('kode_barang')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama
                                        {{ $title }}</label>
                                    <input type="text"
                                        class="form-control @error('nama_barang') is-invalid @enderror"
                                        wire:model.live='nama_barang'>
                                    @error('nama_barang')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pilih Kategori</label>
                                    <select class="form-select" wire:model.change="selectedCategory">
                                        @if ($categories->isEmpty())
                                            <option>Data tidak ditemukan</option>
                                        @else
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Harga Beli</label>
                                            <input type="number"
                                                class="form-control @error('harga_beli') is-invalid @enderror"
                                                wire:model.live='harga_beli'
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            @error('harga_beli')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Harga Jual Awal</label>
                                            <input type="number"
                                                class="form-control @error('harga_jual_awal') is-invalid @enderror"
                                                wire:model.live='harga_jual_awal'
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            @error('harga_jual_awal')
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
                                            <label for="" class="form-label">Diskon</label>
                                            <input type="number"
                                                class="form-control @error('diskon') is-invalid @enderror"
                                                wire:model.live='diskon'
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            @error('diskon')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Harga Jual Akhir</label>
                                            <input type="number"
                                                class="form-control @error('harga_jual_akhir') is-invalid @enderror"
                                                wire:model.live='harga_jual_akhir' disabled>
                                            @error('harga_jual_akhir')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Foto</label>
                                    <input type="file" accept="image/*"
                                        class="form-control @error('photo') is-invalid @enderror"
                                        wire:model.change='photo'>
                                    @error('photo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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

            {{-- Modal Update --}}
            <div wire:ignore.self class="modal fade" id="modalUpdate" data-bs-backdrop="static" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update {{ $title }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                wire:click='clear()'></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent='update'>
                                <div class="mb-3">
                                    <label for="" class="form-label">Kode
                                        {{ $title }}</label>
                                    <input type="text"
                                        class="form-control @error('kode_barang') is-invalid @enderror"
                                        wire:model.live='kode_barang' disabled>
                                    @error('kode_barang')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama
                                        {{ $title }}</label>
                                    <input type="text"
                                        class="form-control @error('nama_barang') is-invalid @enderror"
                                        wire:model.live='nama_barang'>
                                    @error('nama_barang')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Kategori</label>
                                    <select class="form-select" wire:model.change="selectedCategory">
                                        @if ($categories->isEmpty())
                                            <option>Data tidak ditemukan</option>
                                        @else
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Harga Beli</label>
                                            <input type="number"
                                                class="form-control @error('harga_beli') is-invalid @enderror"
                                                wire:model.live='harga_beli'
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            @error('harga_beli')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Harga Jual Awal</label>
                                            <input type="number"
                                                class="form-control @error('harga_jual_awal') is-invalid @enderror"
                                                wire:model.live='harga_jual_awal'
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            @error('harga_jual_awal')
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
                                            <label for="" class="form-label">Diskon</label>
                                            <input type="number"
                                                class="form-control @error('diskon') is-invalid @enderror"
                                                wire:model.live='diskon'
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            @error('diskon')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Harga Jual Akhir</label>
                                            <input type="number"
                                                class="form-control @error('harga_jual_akhir') is-invalid @enderror"
                                                wire:model.live='harga_jual_akhir' disabled>
                                            @error('harga_jual_akhir')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Foto</label> <br>
                                    <img src="{{ $foto ? asset('storage/items/' . $foto) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png' }}"
                                        class="card-img-top mb-3"
                                        style="width: 200px; height: 200px; object-fit: cover;" alt="Profile Picture">
                                    <input type="file" accept="image/*"
                                        class="form-control @error('photo') is-invalid @enderror"
                                        wire:model.change='photo'>
                                    @error('photo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                        wire:click='clear()'>Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Delete --}}
            <div wire:ignore.self class="modal fade" id="modalDelete" data-bs-backdrop="static" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete {{ $title }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Yakin Akan Menghapus Data Ini?</p>
                            <div class="mt-3 text-end">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" wire:click='delete()'>Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
