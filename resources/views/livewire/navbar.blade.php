<div>
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/dashboard">Kasir App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    {{-- Dashboard --}}
                    <a class="btn btn-primary text-start {{ Route::is('dashboard') ? 'active' : '' }}"
                        href="{{ url('dashboard') }}" wire:navigate>Dashboard</a>

                    {{-- Master Data --}}
                    <div class="dropdown">
                        <button
                            class="btn btn-primary dropdown-toggle {{ Route::is('kategori', 'suppliers') ? 'active' : '' }}"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Master Data
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Route::is('kategori') ? 'active' : '' }}"
                                    href="{{ url('kategori') }}" wire:navigate>Kategori</a></li>
                            <li><a class="dropdown-item {{ Route::is('barang') ? 'active' : '' }}"
                                    href="{{ url('barang') }}" wire:navigate>Barang</a></li>
                            <li><a class="dropdown-item {{ Route::is('suppliers') ? 'active' : '' }}"
                                    href="{{ url('suppliers') }}" wire:navigate>Supplier</a></li>
                            <li><a class="dropdown-item {{ Route::is('users') ? 'active' : '' }}"
                                    href="{{ url('users') }}" wire:navigate>User</a></li>
                            <li><a class="dropdown-item" href="#">Membership</a></li>
                        </ul>
                    </div>

                    {{-- Stok --}}
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Stok
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Stok Gudang</a></li>
                            <li><a class="dropdown-item" href="#">Stok Etalase</a></li>
                            <li><a class="dropdown-item" href="#">Riwayat Stok</a></li>
                        </ul>
                    </div>

                    {{-- Transaksi --}}
                    <a class="btn btn-primary text-start" href="#">Transaksi</a>

                    {{-- Laporan --}}
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Laporan
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Laporan</a></li>
                        </ul>
                    </div>
                </div>
                <div class="navbar-nav ms-auto">

                    {{-- Profile --}}
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Profile
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <hr>
                            <li><button class="dropdown-item" wire:click='logout'>Logout</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
