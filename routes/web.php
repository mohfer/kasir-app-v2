<?php

use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Item;
use App\Livewire\Kategori;
use App\Livewire\Membership;
use App\Livewire\Profile;
use App\Livewire\StokEtalase;
use App\Livewire\StokGudang;
use App\Livewire\Supplier;
use App\Livewire\Transaction;
use App\Livewire\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', Login::class)->name('auth.login')->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/items', Item::class)->name('items');
    Route::get('/kategori', Kategori::class)->name('kategori');
    Route::get('/suppliers', Supplier::class)->name('suppliers');
    Route::get('/users', User::class)->name('users');
    Route::get('/membership', Membership::class)->name('membership');

    Route::get('/stok-gudang', StokGudang::class)->name('stok-gudang');
    Route::get('/stok-etalase', StokEtalase::class)->name('stok-etalase');

    Route::get('/transaction', Transaction::class)->name('transaction');



    Route::get('/profile', Profile::class)->name('profile');
});
