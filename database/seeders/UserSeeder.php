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

        $mahasiswaUser = DB::table('users')->where('email', 'mahasiswa@example.com')->first();
        $prodiId = DB::table('prodi')->where('nama', 'Sarjana Terapan Teknologi Rekayasa Perangkat Lunak')->value('id') 
                   ?? DB::table('prodi')->first()->id;

        if ($mahasiswaUser && $prodiId) {
            DB::table('mahasiswa')->insert([
                'user_id' => $mahasiswaUser->id,
                'nim' => '220101001',
                'nama_lengkap' => 'Mahasiswa Demo',
                'prodi_id' => $prodiId,
                'jalur_masuk' => 'SBMPTN',
                'no_hp' => '081234567890',
                'semester_saat_ini' => 3,
                'ukt_awal' => 3000000,
                'piutang_semester_lalu' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
