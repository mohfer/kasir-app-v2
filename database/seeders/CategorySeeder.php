<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Makanan'],
            ['nama_kategori' => 'Minuman'],
            ['nama_kategori' => 'Snack'],
            ['nama_kategori' => 'Elektronik'],
            ['nama_kategori' => 'Peralatan Rumah Tangga'],
            ['nama_kategori' => 'Kosmetik'],
            ['nama_kategori' => 'Obat-obatan'],
            ['nama_kategori' => 'Mainan'],
            ['nama_kategori' => 'Buku & Alat Tulis'],
            ['nama_kategori' => 'Pakaian'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['nama_kategori' => $category['nama_kategori']],
                array_merge($category, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
