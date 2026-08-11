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
            [
                'name' => 'Mahasiswa Demo 6',
                'email' => 'mahasiswa6@example.com',
                'password' => Hash::make('12345'),
                'role' => 'mahasiswa',
                'jurusan_id' => null,
            ],
            [
                'name' => 'Mahasiswa Demo 7',
                'email' => 'mahasiswa7@example.com',
                'password' => Hash::make('12345'),
                'role' => 'mahasiswa',
                'jurusan_id' => null,
            ],
            [
                'name' => 'Mahasiswa Demo 8',
                'email' => 'mahasiswa8@example.com',
                'password' => Hash::make('12345'),
                'role' => 'mahasiswa',
                'jurusan_id' => null,
            ],
            [
                'name' => 'Mahasiswa Demo 9',
                'email' => 'mahasiswa9@example.com',
                'password' => Hash::make('12345'),
                'role' => 'mahasiswa',
                'jurusan_id' => null,
            ],
            [
                'name' => 'Mahasiswa Demo 10',
                'email' => 'mahasiswa10@example.com',
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

        $mahasiswaUser6 = DB::table('users')->where('email', 'mahasiswa6@example.com')->first();
        $prodiId6 = DB::table('prodi')->where('nama', 'like', '%Perangkat Lunak%')->value('id') 
                   ?? DB::table('prodi')->first()?->id;

        if ($mahasiswaUser6 && $prodiId6) {
            DB::table('mahasiswa')->updateOrInsert(
                ['user_id' => $mahasiswaUser6->id],
                [
                    'nim' => '362241311076',
                    'nama_lengkap' => 'Mahasiswa Demo 6',
                    'prodi_id' => $prodiId6,
                    'jalur_masuk' => 'SBMPTN',
                    'no_hp' => '0882' . rand(10000000, 99999999),
                    'semester_saat_ini' => 3,
                    'ukt_awal' => 2000000,
                    'piutang_semester_lalu' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $mahasiswaUser7 = DB::table('users')->where('email', 'mahasiswa7@example.com')->first();
        $prodiId7 = DB::table('prodi')->where('nama', 'like', '%Perangkat Lunak%')->value('id') 
                   ?? DB::table('prodi')->first()?->id;

        if ($mahasiswaUser7 && $prodiId7) {
            DB::table('mahasiswa')->updateOrInsert(
                ['user_id' => $mahasiswaUser7->id],
                [
                    'nim' => '362454346065',
                    'nama_lengkap' => 'Mahasiswa Demo 7',
                    'prodi_id' => $prodiId7,
                    'jalur_masuk' => 'SBMPTN',
                    'no_hp' => '0883' . rand(10000000, 99999999),
                    'semester_saat_ini' => 3,
                    'ukt_awal' => 4000000,
                    'piutang_semester_lalu' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $mahasiswaUser8 = DB::table('users')->where('email', 'mahasiswa8@example.com')->first();
        $prodiId8 = DB::table('prodi')->where('nama', 'like', '%Perangkat Lunak%')->value('id') 
                   ?? DB::table('prodi')->first()?->id;

        if ($mahasiswaUser8 && $prodiId8) {
            DB::table('mahasiswa')->updateOrInsert(
                ['user_id' => $mahasiswaUser8->id],
                [
                    'nim' => '362454846065',
                    'nama_lengkap' => 'Mahasiswa Demo 8',
                    'prodi_id' => $prodiId8,
                    'jalur_masuk' => 'SBMPTN',
                    'no_hp' => '0884' . rand(10000000, 99999999),
                    'semester_saat_ini' => 3,
                    'ukt_awal' => 4000000,
                    'piutang_semester_lalu' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $mahasiswaUser9 = DB::table('users')->where('email', 'mahasiswa9@example.com')->first();
        $prodiId9 = DB::table('prodi')->where('nama', 'like', '%Perangkat Lunak%')->value('id') 
                   ?? DB::table('prodi')->first()?->id;

        if ($mahasiswaUser9 && $prodiId9) {
            DB::table('mahasiswa')->updateOrInsert(
                ['user_id' => $mahasiswaUser9->id],
                [
                    'nim' => '362654846065',
                    'nama_lengkap' => 'Mahasiswa Demo 9',
                    'prodi_id' => $prodiId9,
                    'jalur_masuk' => 'SBMPTN',
                    'no_hp' => '0885' . rand(10000000, 99999999),
                    'semester_saat_ini' => 3,
                    'ukt_awal' => 4000000,
                    'piutang_semester_lalu' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $mahasiswaUser10 = DB::table('users')->where('email', 'mahasiswa10@example.com')->first();
        $prodiId10 = DB::table('prodi')->where('nama', 'like', '%Perangkat Lunak%')->value('id') 
                   ?? DB::table('prodi')->first()?->id;

        if ($mahasiswaUser10 && $prodiId10) {
            DB::table('mahasiswa')->updateOrInsert(
                ['user_id' => $mahasiswaUser10->id],
                [
                    'nim' => '362656846065',
                    'nama_lengkap' => 'Mahasiswa Demo 10',
                    'prodi_id' => $prodiId10,
                    'jalur_masuk' => 'SBMPTN',
                    'no_hp' => '0886' . rand(10000000, 99999999),
                    'semester_saat_ini' => 3,
                    'ukt_awal' => 4000000,
                    'piutang_semester_lalu' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
