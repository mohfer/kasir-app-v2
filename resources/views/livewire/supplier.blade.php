<div>
    <div class="wrapper">
        <div class="container">
            <h1 class="text-center mt-5">{{ $title }}</h1>

            {{-- Alert --}}
            @if (session()->has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col">

                    {{-- Trigger Bulking Delete --}}
                    <div class="text-start mb-3">
                        @if ($selectedSupplierId)
                            <button class="btn btn-danger mt-5" data-bs-toggle="modal" data-bs-target="#modalDelete"
                                wire:click="deleteConfirmation('')">Delete
                                {{ count($selectedSupplierId) }} Data</button>
                        @endif
                    </div>
                </div>
                <div class="col">

                    {{-- Trigger Modal Tambah --}}
                    <div class="text-end mb-3">
                        <button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal"
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
                    @if ($suppliers->isEmpty())
                        <p class="text-center mt-3">No Data</p>
                    @else
                        <table class="table table-striped table-bordered mt-3">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col" class="text-center">
                                        <input type="checkbox" class="form-check-input" wire:model="selectAll"
                                            wire:click="toggleSelectAll">
                                    </th>
                                    <th scope="col">No</th>
                                    <th scope="col" wire:click="sort('nama')">Nama
                                        <span class="float-end" style="cursor: pointer;">
                                            <i
                                                class="bi bi-arrow-down {{ $sortColumn === 'nama' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i
                                                class="bi bi-arrow-up {{ $sortColumn === 'nama' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th scope="col" wire:click="sort('email')">Email <span class="float-end"
                                            style="cursor: pointer;">
                                            <i
                                                class="bi bi-arrow-down {{ $sortColumn === 'email' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i
                                                class="bi bi-arrow-up {{ $sortColumn === 'email' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span></th>
                                    <th scope="col" wire:click="sort('alamat')">Alamat <span class="float-end"
                                            style="cursor: pointer;">
                                            <i
                                                class="bi bi-arrow-down {{ $sortColumn === 'alamat' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i
                                                class="bi bi-arrow-up {{ $sortColumn === 'alamat' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span></th>
                                    <th scope="col" wire:click="sort('telp')">Telp <span class="float-end"
                                            style="cursor: pointer;">
                                            <i
                                                class="bi bi-arrow-down {{ $sortColumn === 'telp' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i
                                                class="bi bi-arrow-up {{ $sortColumn === 'telp' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span></th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $key => $supplier)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="form-check-input"
                                                value="{{ $supplier->id }}" wire:model.live='selectedSupplierId'
                                                wire:key='{{ $supplier->id }}'></td>
                                        <td>{{ $suppliers->firstItem() + $key }}</td>
                                        <td>{{ $supplier->nama }}</td>
                                        <td>{{ $supplier->email }}</td>
                                        <td>{{ $supplier->alamat }}</td>
                                        <td>{{ $supplier->telp }}</td>
                                        <td class="text-center"><button class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#modalUpdate"
                                                wire:click='edit({{ $supplier->id }})'>Edit</button> |
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalDelete"
                                                wire:click='deleteConfirmation({{ $supplier->id }})'>Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col">
                                {{ $suppliers->links() }}
                            </div>
                            <div class="col mt-2 text-end">
                                Jumlah Data: <span class="fw-bold">{{ $countSuppliers }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Modal Tambah --}}
            <div wire:ignore.self class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah
                                Supplier</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                wire:click='clear()'></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent='save'>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama
                                        Supplier</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        wire:model.lazy='nama'>
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        wire:model.lazy='email'>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Alamat</label>
                                    <textarea cols="30" rows="3" class="form-control @error('alamat') is-invalid @enderror"
                                        wire:model.lazy='alamat'></textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Telp</label>
                                    <input type="number" class="form-control @error('telp') is-invalid @enderror"
                                        wire:model.lazy='telp'>
                                    @error('telp')
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
            <div wire:ignore.self class="modal fade" id="modalUpdate" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Kategori</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                wire:click='clear()'></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent='update'>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama
                                        Supplier</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        wire:model.lazy='nama'>
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        wire:model.lazy='email'>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Alamat</label>
                                    <textarea cols="30" rows="3" class="form-control @error('alamat') is-invalid @enderror"
                                        wire:model.lazy='alamat'></textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Telp</label>
                                    <input type="number" class="form-control @error('telp') is-invalid @enderror"
                                        wire:model.lazy='telp'>
                                    @error('telp')
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
            <div wire:ignore.self class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Kategori</h1>
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