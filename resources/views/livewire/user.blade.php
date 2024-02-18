<div>
    <div class="wrapper">
        <div class="container">
            <h1 class="text-center mt-5">{{ $title }}</h1>

            {{-- Alert --}}
            {{-- @if (session()->has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif --}}

            <div class="row">
                <div class="col">

                    {{-- Trigger Bulking Delete --}}
                    {{-- <div class="text-start mb-3">
                        @if ($selectedSupplierId)
                            <button class="btn btn-danger mt-5" data-bs-toggle="modal" data-bs-target="#modalDelete"
                                wire:click="deleteConfirmation('')">Delete
                                {{ count($selectedSupplierId) }} Data</button>
                        @endif
                    </div> --}}
                </div>
                <div class="col">

                    {{-- Trigger Modal Tambah --}}
                    <div class="text-end mb-3">
                        <button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal"
                            data-bs-target="#modalTambah">
                            Tambah {{ $title }}
                        </button>
                    </div>

                    {{-- Modal Tambah --}}
                    <div wire:ignore.self class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
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
                                            <label for="" class="form-label">Nama</label>
                                            <input type="text"
                                                class="form-control @error('nama') is-invalid @enderror"
                                                wire:model.lazy='nama'>
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Username</label>
                                            <input type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                wire:model.lazy='username'>
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                wire:model.lazy='password'>
                                            @error('password')
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
                                                    id="laki-laki" value="Laki - Laki">
                                                <label class="form-check-label" for="laki-laki">Laki - Laki</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                    id="perempuan" value="Perempuan">
                                                <label class="form-check-label" for="perempuan">Perempuan</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Email</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                wire:model.lazy='email'>
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Telp</label>
                                            <input type="number"
                                                class="form-control @error('telp') is-invalid @enderror"
                                                wire:model.lazy='telp'>
                                            @error('telp')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Role</label>
                                            <select class="form-select form-select" aria-label="Small select example">
                                                <option value="Admin">Admin</option>
                                                <option value="Gudang">Gudang</option>
                                                <option value="Kasir">Kasir</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Foto</label>
                                            <input type="file" class="form-control">
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
    </div>
</div>
