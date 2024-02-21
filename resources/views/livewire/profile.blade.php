<div>
    <div class="wrapper">
        <div class="container">
            <div class="row mt-3">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-header fw-bold ">
                            Photo
                        </div>
                        <div class="text-center pt-3">
                            <img src="https://source.unsplash.com/random/500x500" class="card-img-top w-50 rounded-pill"
                                alt="Profile Picture">
                        </div>
                        <div class="card-body text-center">
                            <h3 class="fw-bold">Admin</h3>
                            <p class="fs-4">Mohamad Ferdiansyah</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col text-start">
                                    <h4 class="fw-bold">Data</h4>
                                </div>
                                <div class="col text-end">
                                    <a href="#" class="btn btn-primary">Password</a>
                                </div>
                            </div>
                        </div>
                        <div class="container my-3">
                            <form wire:submit.prevent='save'>
                                <div class="mb-3">
                                    <label for="" class="form-label">Username</label>
                                    <input type="username" class="form-control @error('username') is-invalid @enderror"
                                        wire:model.lazy='username' disabled>
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
                                            id="l" value="L" wire:model="jenis_kelamin">
                                        <label class="form-check-label" for="l">Laki - Laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            id="p" value="P" wire:model="jenis_kelamin">
                                        <label class="form-check-label" for="p">Perempuan</label>
                                    </div>
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
                                    <label for="" class="form-label">Telp</label>
                                    <input type="number" class="form-control @error('telp') is-invalid @enderror"
                                        wire:model.lazy='telp'
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    @error('telp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Foto</label>
                                    <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                        wire:model.lazy='foto'
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    @error('foto')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
