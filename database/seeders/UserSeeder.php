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
                'name' => 'Admin Global',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345'),
                'role' => 'admin',
                'jurusan_id' => null,
            ],
            [
                'name' => 'Staff Keuangan',
                'email' => 'keuangan@example.com',
                'password' => Hash::make('12345'),
                'role' => 'keuangan',
                'jurusan_id' => null,
            ],
            [
                'name' => 'Wadir II',
                'email' => 'wadir2@example.com',
                'password' => Hash::make('12345'),
                'role' => 'wadir',
                'jurusan_id' => null,
            ],
            [
                'name' => 'Mahasiswa Demo',
                'email' => 'mahasiswa@example.com',
                'password' => Hash::make('12345'),
                'role' => 'mahasiswa',
                'jurusan_id' => null,
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'role' => $user['role'],
                'jurusan_id' => $user['jurusan_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create department-specific admins
        $jurusans = [
            'Jurusan Bisnis & Informatika' => 'admin.bisnis@example.com',
            'Jurusan Pariwisata' => 'admin.pariwisata@example.com',
            'Jurusan Pertanian' => 'admin.pertanian@example.com',
            'Jurusan Teknik Mesin' => 'admin.mesin@example.com',
            'Jurusan Teknik Sipil' => 'admin.sipil@example.com',
        ];

        foreach ($jurusans as $namaJurusan => $email) {
            $jurusanId = DB::table('jurusan')->where('nama', $namaJurusan)->value('id');
            
            if ($jurusanId) {
                DB::table('users')->insert([
                    'name' => 'Admin ' . str_replace('Jurusan ', '', $namaJurusan),
                    'email' => $email,
                    'password' => Hash::make('12345'),
                    'role' => 'admin',
                    'jurusan_id' => $jurusanId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
