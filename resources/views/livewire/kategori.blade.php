<div>
    <div class="wrapper">
        <div class="container">

            {{-- Alert --}}
            @if (session()->has('status'))
                <div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                    {{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col">

                    {{-- Trigger Bulking Delete --}}
                    <div class="text-start mb-3">
                        @if ($selectedCategoryId)
                            <button class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#modalDelete"
                                wire:click="deleteConfirmation('')">Delete
                                {{ count($selectedCategoryId) }} Data</button>
                        @endif
                    </div>
                </div>
                <div class="col">

                    {{-- Trigger Modal Tambah --}}
                    <div class="text-end mb-3">
                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                            data-bs-target="#modalTambah">
                            Tambah Kategori
                        </button>
                    </div>
                </div>
            </div>

            {{-- Data --}}
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="fw-bold">Kategori</h4>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Search..." autofocus
                                wire:model.live='searchKey'>
                        </div>
                    </div>
                </div>
                <div class="container">
                    @if ($categories->isEmpty())
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
                                    <th scope="col" wire:click="sort('nama_kategori')">Kategori
                                        <span class="float-end" style="cursor: pointer;">
                                            <i
                                                class="bi bi-arrow-down {{ $sortColumn === 'nama_kategori' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                            <i
                                                class="bi bi-arrow-up {{ $sortColumn === 'nama_kategori' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                        </span>
                                    </th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="form-check-input"
                                                value="{{ $category->id }}" wire:model.live='selectedCategoryId'
                                                wire:key='{{ $category->id }}'></td>
                                        <td>{{ $categories->firstItem() + $key }}</td>
                                        <td>{{ $category->nama_kategori }}</td>
                                        <td class="text-center"><button class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#modalUpdate"
                                                wire:click='edit({{ $category->id }})'>Edit</button> |
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalDelete"
                                                wire:click='deleteConfirmation({{ $category->id }})'>Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col">
                                {{ $categories->links() }}
                            </div>
                            <div class="col mt-2 text-end">
                                Jumlah Data: <span class="fw-bold">{{ $countCategories }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Modal Tambah --}}
            <div wire:ignore.self class="modal fade" id="modalTambah" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah
                                Kategori</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                wire:click='clear()'></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent='save'>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama
                                        Kategori</label>
                                    <input type="text"
                                        class="form-control @error('nama_kategori') is-invalid @enderror"
                                        wire:model.lazy='nama_kategori'>
                                    @error('nama_kategori')
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
            <div wire:ignore.self class="modal fade" id="modalUpdate" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
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
                                    <label for="" class="form-label">Nama Kategori</label>
                                    <input type="text"
                                        class="form-control @error('nama_kategori') is-invalid @enderror"
                                        wire:model.lazy='nama_kategori'>
                                    @error('nama_kategori')
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
            <div wire:ignore.self class="modal fade" id="modalDelete" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
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
