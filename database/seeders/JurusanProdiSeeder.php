<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanProdiSeeder extends Seeder
{
    public function run(): void
    {
        $jurusanProdi = [
            'Jurusan Bisnis & Informatika' => [
                'Sarjana Terapan Teknologi Rekayasa Perangkat Lunak',
                'Sarjana Terapan Bisnis Digital',
                'Sarjana Terapan Teknologi Rekayasa Komputer',
            ],
            'Jurusan Pariwisata' => [
                'Sarjana Terapan Manajemen Bisnis Pariwisata',
                'Sarjana Terapan Destinasi Pariwisata',
                'Sarjana Terapan Pengelolaan Perhotelan',
            ],
            'Jurusan Pertanian' => [
                'Sarjana Terapan Agribisnis',
                'Sarjana Terapan Teknologi Pengolahan Hasil Ternak',
                'Sarjana Terapan Pengembangan Produk Agroindustri',
                'Sarjana Terapan Teknologi Produksi Ternak',
                'Sarjana Terapan Teknologi Produksi Tanaman Pangan',
                'Sarjana Terapan Teknologi Budi Daya Perikanan / Teknologi Akuakultur',
            ],
            'Jurusan Teknik Mesin' => [
                'Sarjana Terapan Teknologi Rekayasa Manufaktur',
                'Sarjana Terapan Teknik Manufaktur Kapal',
            ],
            'Jurusan Teknik Sipil' => [
                'Diploma 3 Teknik Sipil',
                'Sarjana Terapan Teknologi Rekayasa Konstruksi Jalan dan Jembatan',
                'Sarjana Terapan Teknologi Rekayasa Konstruksi Bangunan Gedung',
                'Sarjana Terapan Manajemen Konstruksi',
            ],
        ];

        foreach ($jurusanProdi as $jurusan => $listProdi) {
            $existingJurusan = DB::table('jurusan')->where('nama', $jurusan)->first();
            if ($existingJurusan) {
                $jurusanId = $existingJurusan->id;
            } else {
                $jurusanId = DB::table('jurusan')->insertGetId([
                    'nama' => $jurusan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($listProdi as $prodi) {
                $existingProdi = DB::table('prodi')->where('nama', $prodi)->first();
                if (!$existingProdi) {
                    DB::table('prodi')->insert([
                        'jurusan_id' => $jurusanId,
                        'nama' => $prodi,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
