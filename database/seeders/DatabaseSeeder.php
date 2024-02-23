<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Item;
use App\Models\Membership;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert([
            'nama' => 'Admin',
            'username' => 'ADMIN',
            'password' => bcrypt('password'),
            'jenis_kelamin' => 'L',
            'email' => 'admin@gmail.com',
            'telp' => '083812334555',
            'role' => 'Admin',
            'foto' => '',
        ]);

        DB::table('categories')->insert([
            'nama_kategori' => 'Makanan',
        ]);

        DB::table('items')->insert([
            'kode_barang' => 1165161182858,
            'nama_barang' => 'Chitato',
            'category_id' => 1,
            'harga_beli' => 2000,
            'harga_jual_awal' => 4000,
            'diskon' => 0,
            'harga_jual_akhir' => 4000,
        ]);

        DB::table('suppliers')->insert([
            'nama' => 'PT. Indah Jaya',
            'email' => 'indahjaya@indah.com',
            'alamat' => 'Bojongsari',
            'telp' => 112233,
        ]);

        DB::table('memberships')->insert([
            'kode_member' => 'FOR844',
            'nama' => 'Umum',
            'email' => 'umum@umum.com',
            'telp' => 112233,
            'diskon' => 0,
            'tgl_berlangganan' => '2024-02-23',
            'aktif' => 'Ya',
        ]);

        // User::factory(50)->create();
        // Category::factory(50)->create();
        // Item::factory(50)->create();
        // Supplier::factory(50)->create();
        // Membership::factory(50)->create();
    }
}
