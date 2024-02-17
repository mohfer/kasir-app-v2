<div>
    <div class="container-fluid h-100 mt-5">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-lg-4 col-md-6 col-sm-8 custom-login-container">
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="border shadow-lg p-4 rounded">
                    <h1 class="text-center">Login</h1>
                    <form wire:submit.prevent='login'>
                        <div class="form-group mb-3">
                            <span>Username</span>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username') }}" wire:model.lazy='username'>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <span>Password</span>
                            <input type="{{ $showPassword ? 'text' : 'password' }}"
                                class="form-control  @error('password') is-invalid @enderror"
                                wire:model.lazy='password'>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="togglePasswordVisibility">
                                <label class="form-check-label" for="togglePasswordVisibility"
                                    wire:click='togglePasswordVisibility'>
                                    Show Password
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="text-center btn btn-primary w-100 mt-3">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
