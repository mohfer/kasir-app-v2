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
                        @if ($selectedMemberId)
                            <button class="btn btn-danger mt-5" data-bs-toggle="modal" data-bs-target="#modalDelete"
                                wire:click="deleteConfirmation('')">Delete
                                {{ count($selectedMemberId) }} Data</button>
                        @endif
                    </div>
                </div>
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
                    @if ($members->isEmpty())
                        <p class="text-center mt-3">No Data</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col" class="text-center">
                                            <input type="checkbox" class="form-check-input" wire:model="selectAll"
                                                wire:click="toggleSelectAll">
                                        </th>
                                        <th scope="col">No</th>
                                        <th scope="col" wire:click="sort('kode_member')">Kode Member
                                            <span class="float-end" style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'kode_member' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'kode_member' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span>
                                        </th>
                                        <th scope="col" wire:click="sort('nama')">Nama
                                            <span class="float-end" style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'nama' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'nama' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span>
                                        </th>
                                        <th scope="col" wire:click="sort('diskon')">Diskon <span class="float-end"
                                                style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'diskon' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'diskon' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span></th>
                                        <th scope="col" wire:click="sort('aktif')">Aktif <span class="float-end"
                                                style="cursor: pointer;">
                                                <i
                                                    class="bi bi-arrow-down {{ $sortColumn === 'aktif' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                                <i
                                                    class="bi bi-arrow-up {{ $sortColumn === 'aktif' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                            </span></th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $key => $member)
                                        <tr>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    value="{{ $member->id }}" wire:model.live='selectedMemberId'
                                                    wire:key='{{ $member->id }}'></td>
                                            <td>{{ $members->firstItem() + $key }}</td>
                                            <td>{{ $member->kode_member }}</td>
                                            <td>{{ $member->nama }}</td>
                                            <td>{{ $member->diskon }}%</td>
                                            <td>{{ $member->aktif }}</td>
                                            <td class="text-center"><button class="btn btn-warning"
                                                    data-bs-toggle="modal" data-bs-target="#modalUpdate"
                                                    wire:click='edit({{ $member->id }})'>Detail</button> |
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#modalDelete"
                                                    wire:click='deleteConfirmation({{ $member->id }})'>Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col">
                                {{ $members->links() }}
                            </div>
                            <div class="col mt-2 text-end">
                                Jumlah Data: <span class="fw-bold">{{ $countMembers }}</span>
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
                            <form wire:submit.prevent='save'>
                                <div class="mb-3">
                                    <small><span class="text-danger">*Diskon akan terisi
                                            otomatis sebesar 5%.</span></small>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Kode Member</label>
                                    <input type="kode_member"
                                        class="form-control @error('kode_member') is-invalid @enderror"
                                        wire:model.live='kode_member' disabled>
                                    @error('kode_member')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        wire:model.live='email'>
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
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
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
                                    <label for="" class="form-label">Kode Member</label>
                                    <input type="kode_member"
                                        class="form-control @error('kode_member') is-invalid @enderror"
                                        wire:model.live='kode_member' disabled>
                                    @error('kode_member')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        wire:model.live='email'>
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
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    @error('telp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Diskon</label>
                                    <input type="number" class="form-control @error('diskon') is-invalid @enderror"
                                        wire:model.live='diskon'
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    @error('diskon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Berlangganan</label>
                                    <input type="tgl_berlangganan"
                                        class="form-control @error('tgl_berlangganan') is-invalid @enderror"
                                        wire:model.live='tgl_berlangganan' disabled>
                                    @error('tgl_berlangganan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Aktif</label>
                                    <select class="form-select form-select" wire:model="selectedAktif">
                                        <option value="Ya">Ya</option>
                                        <option value="Tidak">Tidak</option>
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
</div>
