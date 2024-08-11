<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nik' => '1234567890123456',
                'nama' => 'Jesica Aprilia',
                'tempat' => 'Pekanbaru',
                'tanggal_lahir' => '2003-04-05',
                'alamat' => 'Jl. Bangau Sakti',
                'no_hp' => '085763691652',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'validasi' => 'diterima',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '1234567890123457',
                'nama' => 'User',
                'tempat' => 'Pekanbaru',
                'tanggal_lahir' => now(),
                'alamat' => 'Pekanbaru',
                'no_hp' => '081234567891',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'validasi' => 'menunggu validasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
