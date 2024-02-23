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
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ Session::get('error') }}
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
                    @if ($users->isEmpty())
                        <p class="text-center mt-3">No Data</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col" wire:click="sort('nama')">Nama
                                            <span class="float-end" style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'nama' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'nama' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span>
                                        </th>

                                        <th scope="col" wire:click="sort('telp')">Telp <span class="float-end"
                                                style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'telp' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'telp' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span></th>
                                        <th scope="col" wire:click="sort('role')">Role <span class="float-end"
                                                style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'role' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'role' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span></th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ $users->firstItem() + $key }}</td>
                                            <td>{{ $user->nama }}</td>
                                            <td>{{ $user->telp }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td class="text-center"><button class="btn btn-warning"
                                                    data-bs-toggle="modal" data-bs-target="#modalUpdate"
                                                    wire:click='edit({{ $user->id }})'>Detail</button> |
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#modalDelete"
                                                    wire:click='deleteConfirmation({{ $user->id }})'>Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col">
                                {{ $users->links() }}
                            </div>
                            <div class="col mt-2 text-end">
                                Jumlah Data: <span class="fw-bold">{{ $countUsers }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Modal Tambah --}}
            <div wire:ignore.self class="modal fade" id="modalTambah" data-bs-backdrop="static" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah
                                {{ $title }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                wire:click='clear()'></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent='save'>
                                <div class="mb-3">
                                    <small><span class="text-danger">*Password akan terisi
                                            otomatis sesuai dengan nama dan menggunakan huruf
                                            kecil.</span></small>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        wire:model.live='nama'>
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Role</label>
                                    <select class="form-select form-select" wire:model="selectedRole">
                                        <option value="Admin">Admin</option>
                                        <option value="Gudang">Gudang</option>
                                        <option value="Kasir">Kasir</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        wire:model.live='username'>
                                    @error('username')
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
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        wire:model.live='nama'>
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        wire:model.live='username' disabled>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Jenis Kelamin</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            id="l" value="L" wire:model="jenis_kelamin" disabled>
                                        <label class="form-check-label" for="l">Laki - Laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            id="p" value="P" wire:model="jenis_kelamin" disabled>
                                        <label class="form-check-label" for="p">Perempuan</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        wire:model.live='email' disabled>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Telp</label>
                                    <input type="number" class="form-control @error('telp') is-invalid @enderror"
                                        wire:model.live='telp'
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57" disabled>
                                    @error('telp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Role</label>
                                    <select class="form-select form-select" wire:model="selectedRole">
                                        <option value="Admin">Admin</option>
                                        <option value="Gudang">Gudang</option>
                                        <option value="Kasir">Kasir</option>
                                    </select>
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
