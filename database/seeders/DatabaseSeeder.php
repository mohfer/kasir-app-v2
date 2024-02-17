<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
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
            'username' => 'admin',
            'password' => bcrypt('password'),
            'jenis_kelamin' => 'L',
            'email' => 'admin@gmail.com',
            'telp' => '083812334555',
            'role' => 'Admin',
            'foto' => '',
        ]);

        Category::factory(50)->create();
    }
}
