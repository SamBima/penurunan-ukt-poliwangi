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
            [
                'name' => 'Mahasiswa Demo 2',
                'email' => 'mahasiswa2@example.com',
                'password' => Hash::make('12345'),
                'role' => 'mahasiswa',
                'jurusan_id' => null,
            ],
            [
                'name' => 'Mahasiswa Demo 3',
                'email' => 'mahasiswa3@example.com',
                'password' => Hash::make('12345'),
                'role' => 'mahasiswa',
                'jurusan_id' => null,
            ],
            [
                'name' => 'Mahasiswa Demo 4',
                'email' => 'mahasiswa4@example.com',
                'password' => Hash::make('12345'),
                'role' => 'mahasiswa',
                'jurusan_id' => null,
            ],
            [
                'name' => 'Mahasiswa Demo 5',
                'email' => 'mahasiswa5@example.com',
                'password' => Hash::make('12345'),
                'role' => 'mahasiswa',
                'jurusan_id' => null,
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'role' => $user['role'],
                    'jurusan_id' => $user['jurusan_id'],
                    'status' => 'active',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $jurusans = [
            'Bisnis'     => 'admin.bisnis@example.com',
            'Pariwisata' => 'admin.pariwisata@example.com',
            'Pertanian'  => 'admin.pertanian@example.com',
            'Mesin'      => 'admin.mesin@example.com',
            'Sipil'      => 'admin.sipil@example.com',
        ];

        foreach ($jurusans as $keyword => $email) {
            $jurusan = DB::table('jurusan')->where('nama', 'like', "%{$keyword}%")->first();
            
            if ($jurusan) {
                DB::table('users')->updateOrInsert(
                    ['email' => $email],
                    [
                        'name' => 'Admin ' . str_replace('Jurusan ', '', $jurusan->nama),
                        'password' => Hash::make('12345'),
                        'role' => 'admin',
                        'jurusan_id' => $jurusan->id,
                        'status' => 'active',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }

        $mahasiswaUser = DB::table('users')->where('email', 'mahasiswa@example.com')->first();
        $prodiId = DB::table('prodi')->where('nama', 'like', '%Perangkat Lunak%')->value('id') 
                   ?? DB::table('prodi')->first()?->id;

        if ($mahasiswaUser && $prodiId) {
            DB::table('mahasiswa')->updateOrInsert(
                ['user_id' => $mahasiswaUser->id],
                [
                    'nim' => '362141311034',
                    'nama_lengkap' => 'Mahasiswa Demo',
                    'prodi_id' => $prodiId,
                    'jalur_masuk' => 'SBMPTN',
                    'no_hp' => '081234567890',
                    'semester_saat_ini' => 3,
                    'ukt_awal' => 4000000,
                    'piutang_semester_lalu' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $mahasiswaUser2 = DB::table('users')->where('email', 'mahasiswa2@example.com')->first();
        $prodiId2 = DB::table('prodi')->where('nama', 'like', '%Perangkat Lunak%')->value('id') 
                   ?? DB::table('prodi')->first()?->id;

        if ($mahasiswaUser2 && $prodiId2) {
            DB::table('mahasiswa')->updateOrInsert(
                ['user_id' => $mahasiswaUser2->id],
                [
                    'nim' => '362141311035',
                    'nama_lengkap' => 'Mahasiswa Demo 2',
                    'prodi_id' => $prodiId2,
                    'jalur_masuk' => 'SBMPTN',
                    'no_hp' => '081234567860',
                    'semester_saat_ini' => 3,
                    'ukt_awal' => 5000000,
                    'piutang_semester_lalu' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $mahasiswaUser3 = DB::table('users')->where('email', 'mahasiswa3@example.com')->first();
        $prodiId3 = DB::table('prodi')->where('nama', 'like', '%Perangkat Lunak%')->value('id') 
                   ?? DB::table('prodi')->first()?->id;

        if ($mahasiswaUser3 && $prodiId3) {
            DB::table('mahasiswa')->updateOrInsert(
                ['user_id' => $mahasiswaUser3->id],
                [
                    'nim' => '362141311036',
                    'nama_lengkap' => 'Mahasiswa Demo 3',
                    'prodi_id' => $prodiId3,
                    'jalur_masuk' => 'SBMPTN',
                    'no_hp' => '081234567790',
                    'semester_saat_ini' => 3,
                    'ukt_awal' => 5000000,
                    'piutang_semester_lalu' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $mahasiswaUser4 = DB::table('users')->where('email', 'mahasiswa4@example.com')->first();
        $prodiId4 = DB::table('prodi')->where('nama', 'like', '%Perangkat Lunak%')->value('id') 
                   ?? DB::table('prodi')->first()?->id;

        if ($mahasiswaUser4 && $prodiId4) {
            DB::table('mahasiswa')->updateOrInsert(
                ['user_id' => $mahasiswaUser4->id],
                [
                    'nim' => '362141311037',
                    'nama_lengkap' => 'Mahasiswa Demo 4',
                    'prodi_id' => $prodiId4,
                    'jalur_masuk' => 'SBMPTN',
                    'no_hp' => '081234567690',
                    'semester_saat_ini' => 3,
                    'ukt_awal' => 5000000,
                    'piutang_semester_lalu' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $mahasiswaUser5 = DB::table('users')->where('email', 'mahasiswa5@example.com')->first();
        $prodiId5 = DB::table('prodi')->where('nama', 'like', '%Perangkat Lunak%')->value('id') 
                   ?? DB::table('prodi')->first()?->id;

        if ($mahasiswaUser5 && $prodiId5) {
            DB::table('mahasiswa')->updateOrInsert(
                ['user_id' => $mahasiswaUser5->id],
                [
                    'nim' => '362141311038',
                    'nama_lengkap' => 'Mahasiswa Demo 5',
                    'prodi_id' => $prodiId5,
                    'jalur_masuk' => 'SBMPTN',
                    'no_hp' => '081234567590',
                    'semester_saat_ini' => 3,
                    'ukt_awal' => 2000000,
                    'piutang_semester_lalu' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
