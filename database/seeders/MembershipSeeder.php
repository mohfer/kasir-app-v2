<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberships = [
            [
                'kode_member' => 'FOR844',
                'nama' => 'Umum',
                'email' => 'umum@umum.com',
                'telp' => '112233',
                'diskon' => 0,
                'tgl_berlangganan' => '2024-02-23',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_member' => 'PRE001',
                'nama' => 'Premium',
                'email' => 'premium@member.com',
                'telp' => '089765432123',
                'diskon' => 5,
                'tgl_berlangganan' => '2024-02-23',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_member' => 'VIP002',
                'nama' => 'VIP Customer',
                'email' => 'vip@member.com',
                'telp' => '081255667788',
                'diskon' => 10,
                'tgl_berlangganan' => '2024-02-23',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_member' => 'SIL003',
                'nama' => 'Silver Member',
                'email' => 'silver@member.com',
                'telp' => '081234567891',
                'diskon' => 3,
                'tgl_berlangganan' => '2024-03-01',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_member' => 'GOL004',
                'nama' => 'Gold Member',
                'email' => 'gold@member.com',
                'telp' => '081234567892',
                'diskon' => 7,
                'tgl_berlangganan' => '2024-03-05',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_member' => 'DIA005',
                'nama' => 'Diamond Member',
                'email' => 'diamond@member.com',
                'telp' => '081234567893',
                'diskon' => 15,
                'tgl_berlangganan' => '2024-03-10',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_member' => 'REG006',
                'nama' => 'Regular Customer',
                'email' => 'regular@customer.com',
                'telp' => '081234567894',
                'diskon' => 2,
                'tgl_berlangganan' => '2024-03-15',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_member' => 'COR007',
                'nama' => 'Corporate',
                'email' => 'corporate@business.com',
                'telp' => '081234567895',
                'diskon' => 12,
                'tgl_berlangganan' => '2024-03-20',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_member' => 'STU008',
                'nama' => 'Student Member',
                'email' => 'student@education.com',
                'telp' => '081234567896',
                'diskon' => 8,
                'tgl_berlangganan' => '2024-03-25',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_member' => 'BUS009',
                'nama' => 'Business Partner',
                'email' => 'business@partner.com',
                'telp' => '081234567897',
                'diskon' => 20,
                'tgl_berlangganan' => '2024-04-01',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_member' => 'NEW010',
                'nama' => 'New Customer',
                'email' => 'new@customer.com',
                'telp' => '081234567898',
                'diskon' => 1,
                'tgl_berlangganan' => '2024-04-05',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_member' => 'FAM011',
                'nama' => 'Family Pack',
                'email' => 'family@pack.com',
                'telp' => '081234567899',
                'diskon' => 6,
                'tgl_berlangganan' => '2024-04-10',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_member' => 'SPE012',
                'nama' => 'Special Member',
                'email' => 'special@member.com',
                'telp' => '081234567800',
                'diskon' => 25,
                'tgl_berlangganan' => '2024-04-15',
                'aktif' => 'Ya',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($memberships as $membership) {
            DB::table('memberships')->updateOrInsert(
                ['kode_member' => $membership['kode_member']],
                $membership
            );
        }
    }
}
