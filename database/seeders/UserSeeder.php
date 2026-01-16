<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Prodi',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345'),
                'role' => 'admin',
            ],
            [
                'name' => 'Staff Keuangan',
                'email' => 'keuangan@example.com',
                'password' => Hash::make('12345'),
                'role' => 'keuangan',
            ],
            [
                'name' => 'Wadir II',
                'email' => 'wadir2@example.com',
                'password' => Hash::make('12345'),
                'role' => 'wadir',
            ],
            [
                'name' => 'Mahasiswa Demo',
                'email' => 'mahasiswa@example.com',
                'password' => Hash::make('12345'),
                'role' => 'mahasiswa',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'role' => $user['role'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
