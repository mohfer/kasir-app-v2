<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'kode_barang' => '1165161182858',
                'nama_barang' => 'Chitato',
                'category_id' => 1,
                'harga_beli' => 2000,
                'harga_jual_awal' => 4000,
                'diskon' => 0,
                'harga_jual_akhir' => 4000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => '1165161182859',
                'nama_barang' => 'Aqua Botol',
                'category_id' => 2,
                'harga_beli' => 1500,
                'harga_jual_awal' => 3000,
                'diskon' => 0,
                'harga_jual_akhir' => 3000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => '1165161182860',
                'nama_barang' => 'Oreo',
                'category_id' => 3,
                'harga_beli' => 2500,
                'harga_jual_awal' => 5000,
                'diskon' => 0,
                'harga_jual_akhir' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => '1165161182861',
                'nama_barang' => 'Indomie Goreng',
                'category_id' => 1,
                'harga_beli' => 2500,
                'harga_jual_awal' => 4000,
                'diskon' => 500,
                'harga_jual_akhir' => 3500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => '1165161182862',
                'nama_barang' => 'Coca Cola 330ml',
                'category_id' => 2,
                'harga_beli' => 3000,
                'harga_jual_awal' => 5000,
                'diskon' => 0,
                'harga_jual_akhir' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => '1165161182863',
                'nama_barang' => 'Tango Wafer',
                'category_id' => 3,
                'harga_beli' => 1500,
                'harga_jual_awal' => 3000,
                'diskon' => 200,
                'harga_jual_akhir' => 2800,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => '1165161182864',
                'nama_barang' => 'Beras Premium 5kg',
                'category_id' => 1,
                'harga_beli' => 45000,
                'harga_jual_awal' => 60000,
                'diskon' => 5000,
                'harga_jual_akhir' => 55000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => '1165161182865',
                'nama_barang' => 'Teh Botol Sosro',
                'category_id' => 2,
                'harga_beli' => 2000,
                'harga_jual_awal' => 3500,
                'diskon' => 0,
                'harga_jual_akhir' => 3500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => '1165161182866',
                'nama_barang' => 'Biskuit Marie',
                'category_id' => 3,
                'harga_beli' => 3000,
                'harga_jual_awal' => 5500,
                'diskon' => 500,
                'harga_jual_akhir' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => '1165161182867',
                'nama_barang' => 'Minyak Goreng 1L',
                'category_id' => 1,
                'harga_beli' => 12000,
                'harga_jual_awal' => 16000,
                'diskon' => 1000,
                'harga_jual_akhir' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($items as $item) {
            DB::table('items')->updateOrInsert(
                ['kode_barang' => $item['kode_barang']],
                $item
            );
        }
    }
}
