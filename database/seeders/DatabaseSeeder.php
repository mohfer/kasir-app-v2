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

        DB::table('users')->updateOrInsert(
            ['username' => 'ADMIN'],
            [
                'nama' => 'Admin',
                'username' => 'ADMIN',
                'password' => bcrypt('password'),
                'jenis_kelamin' => 'L',
                'email' => 'admin@gmail.com',
                'telp' => '083812334555',
                'role' => 'Admin',
                'foto' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Call individual seeders
        $this->call([
            CategorySeeder::class,
            SupplierSeeder::class,
            MembershipSeeder::class,
            ItemSeeder::class,
        ]);

        // User::factory(50)->create();
        // Category::factory(50)->create();
        // Item::factory(50)->create();
        // Supplier::factory(50)->create();
        // Membership::factory(50)->create();
    }
}
