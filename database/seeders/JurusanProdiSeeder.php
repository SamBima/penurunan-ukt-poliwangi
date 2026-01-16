<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanProdiSeeder extends Seeder
{
    public function run(): void
    {
        $jurusanProdi = [
            'Bisnis dan Informatika' => [
                'Teknologi Rekayasa Perangkat Lunak',
                'Teknologi Rekayasa Manufaktur',
                'Bisnis Digital',
            ],
            'Manajemen Pariwisata' => [
                'Manajemen Bisnis Pariwisata',
                'Pengelolaan Perhotelan',
                'Destinasi Pariwisata',
            ],
            'Pertanian' => [
                'Agribisnis',
                'Teknologi Pengelolaan Hasil Ternak',
                'Teknologi Akuakultur',
                'Teknologi Produksi Ternak',
                'Teknologi Produksi Tanaman Pangan',
                'Pengembangan Produk Agroindustri',
            ],
            'Mesin' => [
                'Teknologi Rekayasa Manufaktur',
                'Teknik Manufaktur Kapal',
            ],
            'Teknik Sipil' => [
                'Teknik Sipil',
                'Teknologi Rekayasa Konstruksi Jalan dan Jembatan',
                'Teknologi Rekayasa Bangunan Gedung',
                'Studi Manajemen Konstruksi',
            ],
        ];

        foreach ($jurusanProdi as $jurusan => $listProdi) {
            $jurusanId = DB::table('jurusan')->insertGetId([
                'nama' => $jurusan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($listProdi as $prodi) {
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
