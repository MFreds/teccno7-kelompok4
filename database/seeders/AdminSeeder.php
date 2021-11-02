<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Akun Admin',
            'email' => 'admin@email.com',
            'is_admin' => 1,
            'password' => Hash::make('12345678'),
        ]);

        DB::table('users')->insert([
            'name' => 'Akun Biasa',
            'email' => 'biasa@email.com',
            'is_admin' => 0,
            'password' => Hash::make('12345678'),
        ]);
    }
}
