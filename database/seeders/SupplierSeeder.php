<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'nama' => 'PT. Indah Jaya',
                'email' => 'indahjaya@indah.com',
                'alamat' => 'Bojongsari',
                'telp' => '112233',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'CV Makmur Sejahtera',
                'email' => 'makmur@sejahtera.com',
                'alamat' => 'Jl. Raya Utama No. 45',
                'telp' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'UD Sinar Abadi',
                'email' => 'sinar@abadi.com',
                'alamat' => 'Jl. Pahlawan No. 12',
                'telp' => '087654321098',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Maju Bersama',
                'email' => 'info@majubersama.com',
                'alamat' => 'Jl. Industri No. 88',
                'telp' => '081998765432',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'CV Berkah Mandiri',
                'email' => 'berkah@mandiri.com',
                'alamat' => 'Jl. Perdagangan No. 15',
                'telp' => '082111222333',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'UD Rezeki Nusantara',
                'email' => 'rezeki@nusantara.com',
                'alamat' => 'Komplek Ruko Makmur Blok A-5',
                'telp' => '083445566778',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Global Distribusi',
                'email' => 'sales@globaldistribusi.com',
                'alamat' => 'Jl. Bypass No. 200',
                'telp' => '084556677889',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'CV Sumber Rejeki',
                'email' => 'sumber@rejeki.com',
                'alamat' => 'Jl. Veteran No. 35',
                'telp' => '085667788990',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT. Aneka Distribusi',
                'email' => 'aneka@distribusi.com',
                'alamat' => 'Jl. Sudirman No. 77',
                'telp' => '086778899001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'CV Cahaya Terang',
                'email' => 'cahaya@terang.com',
                'alamat' => 'Jl. Merdeka No. 99',
                'telp' => '087889900112',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($suppliers as $supplier) {
            DB::table('suppliers')->updateOrInsert(
                ['email' => $supplier['email']],
                $supplier
            );
        }
    }
}
