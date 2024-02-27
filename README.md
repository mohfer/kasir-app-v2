<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Aplikasi Kasir Dengan Laravel Dan Livewire

Aplikasi kasir ini dirancang untuk membantu pemilik bisnis kecil mengelola transaksi penjualan secara efisien dan akurat. Dengan antarmuka yang intuitif, pengguna dapat dengan mudah menambahkan produk, menghitung total pembayaran, dan melihat riwayat transaksi.

## Fitur

-   Tambahkan produk dengan nama, harga, dan jumlah.
-   Hitung total pembayaran secara otomatis.
-   Lihat riwayat transaksi untuk melacak aktivitas penjualan.
-   Dll.

## Role

-   Admin
-   Gudang
-   Kasir

## Diperlukan

-   Composer
-   PHP version of 8.1.
-   MySql

## Instalasi

Install Projek Dengan Git Clone

```bash
git clone https://github.com/Delendins/kasir-app-v2.git
```

Masuk Kedalam Projek

```bash
cd kasir-app-v2
```

Install Dependensi Yang Dibutuhkan

```bash
composer install
```

Buat .env File

```bash
cp .env.example .env
```

Generate .env Key

```bash
php artisan key:generate
```

Migrasi Database Dan Menambahkan Seeder

```bash
php artisan migrate --seed
```

atau

```bash
php artisan migrate:fresh --seed
```

Link Storage

```bash
php artisan storage:link
```

Jalankan

```bash
php artisan ser
```

## Login

-   Username: admin
-   Password: password
