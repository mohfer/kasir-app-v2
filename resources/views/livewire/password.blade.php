<div>
    <div class="wrapper">
        <div class="container">

            @if (session()->has('status'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row mt-3">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-header fw-bold ">
                            Photo
                        </div>
                        <div class="text-center pt-3">
                            <img src="{{ $foto ? asset('storage/photos/' . $foto) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png' }}"
                                class="card-img-top rounded-circle"
                                style="width: 200px; height: 200px; object-fit: cover;" alt="Profile Picture">
                        </div>
                        <div class="card-body text-center">
                            <h3 class="fw-bold">{{ $role }}</h3>
                            <p class="fs-4">{{ $nama }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col text-start">
                                    <h4 class="fw-bold">Password</h4>
                                </div>
                                <div class="col text-end">
                                    <a class="btn btn-primary text-start" href="{{ url('profile') }}"
                                        wire:navigate>Profile</a>
                                </div>
                            </div>
                        </div>
                        <div class="container my-3">
                            <form wire:submit.prevent='save'>
                                <div class="mb-3">
                                    <label for="" class="form-label">Old Password</label>
                                    <input type="{{ $showPassword ? 'text' : 'password' }}"
                                        class="form-control @error('oldPassword') is-invalid @enderror"
                                        wire:model.live='oldPassword'>
                                    @error('oldPassword')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">New Password</label>
                                    <input type="{{ $showPassword ? 'text' : 'password' }}"
                                        class="form-control @error('newPassword') is-invalid @enderror"
                                        wire:model.live='newPassword'>
                                    @error('newPassword')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Confirm Password</label>
                                    <input type="{{ $showPassword ? 'text' : 'password' }}"
                                        class="form-control @error('confirmPassword') is-invalid @enderror"
                                        wire:model.live='confirmPassword'>
                                    @error('confirmPassword')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="togglePasswordVisibility">
                                    <label class="form-check-label" for="togglePasswordVisibility"
                                        wire:click='togglePasswordVisibility'>
                                        Show Password
                                    </label>
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
