<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswaData = [
            [
                'nama' => 'Ahmad Fauzi',
                'nim' => '362155401181',
                'email' => 'ahmad.fauzi@example.com',
                'prodi' => 'Sarjana Terapan Teknologi Rekayasa Perangkat Lunak',
                'ukt_awal' => 3000000,
                'pekerjaan_ayah' => 'Buruh Harian Lepas',
                'penghasilan_ayah' => 1500000,
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => 0,
                'jumlah_tanggungan' => 3,
                'daya_listrik' => 900,
                'tagihan_listrik' => 120000,
                'tagihan_pdam' => 40000,
                'pbb' => 30000,
                'jumlah_motor' => 1,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'SKTM',
                'alasan' => 'Pendapatan ayah sebagai buruh harian tidak menentu dan harus membiayai sekolah adik-adik.',
            ],
            [
                'nama' => 'Budi Santoso',
                'nim' => '362155401182',
                'email' => 'budi.santoso@example.com',
                'prodi' => 'Sarjana Terapan Manajemen Bisnis Pariwisata',
                'ukt_awal' => 2500000,
                'pekerjaan_ayah' => 'Petani/Pekebun',
                'penghasilan_ayah' => 1000000,
                'pekerjaan_ibu' => 'Petani/Pekebun',
                'penghasilan_ibu' => 500000,
                'jumlah_tanggungan' => 2,
                'daya_listrik' => 450,
                'tagihan_listrik' => 60000,
                'tagihan_pdam' => 0,
                'pbb' => 15000,
                'jumlah_motor' => 1,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'kip',
                'alasan' => 'Hasil tani yang tidak menentu dan cuaca buruk mengakibatkan pendapatan menurun drastis.',
            ],
            [
                'nama' => 'Citra Lestari',
                'nim' => '362155401183',
                'email' => 'citra.lestari@example.com',
                'prodi' => 'Diploma 3 Teknik Sipil',
                'ukt_awal' => 1500000,
                'pekerjaan_ayah' => 'Wiraswasta',
                'penghasilan_ayah' => 2000000,
                'pekerjaan_ibu' => 'Pedagang',
                'penghasilan_ibu' => 1000000,
                'jumlah_tanggungan' => 4,
                'daya_listrik' => 1300,
                'tagihan_listrik' => 180000,
                'tagihan_pdam' => 60000,
                'pbb' => 50000,
                'jumlah_motor' => 2,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'tidak_ada',
                'alasan' => 'Tanggungan keluarga yang banyak dan biaya kuliah kakak juga sangat berat.',
            ],
            [
                'nama' => 'Dedi Kurniawan',
                'nim' => '362155401184',
                'email' => 'dedi.kurniawan@example.com',
                'prodi' => 'Sarjana Terapan Teknologi Rekayasa Perangkat Lunak',
                'ukt_awal' => 3000000,
                'pekerjaan_ayah' => 'Nelayan',
                'penghasilan_ayah' => 1200000,
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => 0,
                'jumlah_tanggungan' => 3,
                'daya_listrik' => 450,
                'tagihan_listrik' => 50000,
                'tagihan_pdam' => 0,
                'pbb' => 10000,
                'jumlah_motor' => 1,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'KKS',
                'alasan' => 'Hasil laut yang tidak menentu dan kondisi kapal ayah yang sering rusak.',
            ],
            [
                'nama' => 'Eka Putri',
                'nim' => '362155401185',
                'email' => 'eka.putri@example.com',
                'prodi' => 'Sarjana Terapan Destinasi Pariwisata',
                'ukt_awal' => 2000000,
                'pekerjaan_ayah' => 'Buruh Harian Lepas',
                'penghasilan_ayah' => 1300000,
                'pekerjaan_ibu' => 'Buruh Harian Lepas',
                'penghasilan_ibu' => 800000,
                'jumlah_tanggungan' => 2,
                'daya_listrik' => 900,
                'tagihan_listrik' => 110000,
                'tagihan_pdam' => 30000,
                'pbb' => 25000,
                'jumlah_motor' => 1,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'pkh',
                'alasan' => 'Pendapatan kedua orang tua sebagai buruh harian sangat kecil untuk mencukupi kebutuhan sehari-hari.',
            ],
            [
                'nama' => 'Fajar Hidayat',
                'nim' => '362155401186',
                'email' => 'fajar.hidayat@example.com',
                'prodi' => 'Diploma 3 Teknik Sipil',
                'ukt_awal' => 1500000,
                'pekerjaan_ayah' => 'Pedagang',
                'penghasilan_ayah' => 1800000,
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => 0,
                'jumlah_tanggungan' => 3,
                'daya_listrik' => 900,
                'tagihan_listrik' => 95000,
                'tagihan_pdam' => 35000,
                'pbb' => 20000,
                'jumlah_motor' => 1,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'tidak_ada',
                'alasan' => 'Dagangan orang tua sepi pembeli dan modal usaha habis untuk biaya pengobatan nenek.',
            ],
            [
                'nama' => 'Gita Permata',
                'nim' => '362155401187',
                'email' => 'gita.permata@example.com',
                'prodi' => 'Sarjana Terapan Manajemen Bisnis Pariwisata',
                'ukt_awal' => 2500000,
                'pekerjaan_ayah' => 'Wiraswasta',
                'penghasilan_ayah' => 2500000,
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => 0,
                'jumlah_tanggungan' => 1,
                'daya_listrik' => 1300,
                'tagihan_listrik' => 150000,
                'tagihan_pdam' => 50000,
                'pbb' => 40000,
                'jumlah_motor' => 2,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'tidak_ada',
                'alasan' => 'Usaha bengkel kecil milik ayah sepi karena banyak pesaing baru di sekitar rumah.',
            ],
            [
                'nama' => 'Hendra Wijaya',
                'nim' => '362155401188',
                'email' => 'hendra.wijaya@example.com',
                'prodi' => 'Sarjana Terapan Teknologi Rekayasa Perangkat Lunak',
                'ukt_awal' => 3000000,
                'pekerjaan_ayah' => 'PNS',
                'penghasilan_ayah' => 4500000,
                'pekerjaan_ibu' => 'PNS',
                'penghasilan_ibu' => 3500000,
                'jumlah_tanggungan' => 5,
                'daya_listrik' => 2200,
                'tagihan_listrik' => 350000,
                'tagihan_pdam' => 120000,
                'pbb' => 150000,
                'jumlah_motor' => 3,
                'jumlah_mobil' => 1,
                'kepemilikan_kartu' => 'tidak_ada',
                'alasan' => 'Tanggungan anak sekolah yang banyak dan cicilan bank yang cukup besar.',
            ],
            [
                'nama' => 'Indah Cahyani',
                'nim' => '362155401189',
                'email' => 'indah.cahyani@example.com',
                'prodi' => 'Sarjana Terapan Destinasi Pariwisata',
                'ukt_awal' => 2000000,
                'pekerjaan_ayah' => 'Tidak Bekerja',
                'penghasilan_ayah' => 0,
                'pekerjaan_ibu' => 'Buruh Harian Lepas',
                'penghasilan_ibu' => 900000,
                'jumlah_tanggungan' => 2,
                'daya_listrik' => 450,
                'tagihan_listrik' => 45000,
                'tagihan_pdam' => 0,
                'pbb' => 12000,
                'jumlah_motor' => 1,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'kip',
                'alasan' => 'Ayah sedang sakit stroke dan tidak bisa bekerja, beban keluarga kini ada pada ibu sebagai buruh.',
            ],
            [
                'nama' => 'Joko Susilo',
                'nim' => '362155401190',
                'email' => 'joko.susilo@example.com',
                'prodi' => 'Diploma 3 Teknik Sipil',
                'ukt_awal' => 1500000,
                'pekerjaan_ayah' => 'Petani/Pekebun',
                'penghasilan_ayah' => 800000,
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => 0,
                'jumlah_tanggungan' => 3,
                'daya_listrik' => 450,
                'tagihan_listrik' => 40000,
                'tagihan_pdam' => 0,
                'pbb' => 10000,
                'jumlah_motor' => 1,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'SKTM',
                'alasan' => 'Pendapatan bertani sangat minim dan adik saya ada yang menderita penyakit kronis.',
            ],
            [
                'nama' => 'Kartika Sari',
                'nim' => '362155401191',
                'email' => 'kartika.sari@example.com',
                'prodi' => 'Sarjana Terapan Teknologi Rekayasa Perangkat Lunak',
                'ukt_awal' => 3000000,
                'pekerjaan_ayah' => 'Buruh Harian Lepas',
                'penghasilan_ayah' => 1400000,
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => 0,
                'jumlah_tanggungan' => 4,
                'daya_listrik' => 900,
                'tagihan_listrik' => 100000,
                'tagihan_pdam' => 40000,
                'pbb' => 25000,
                'jumlah_motor' => 1,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'KKS',
                'alasan' => 'Ayah sudah lanjut usia dan sering sakit-sakitan, tanggungan anak sekolah masih banyak.',
            ],
            [
                'nama' => 'Lukman Hakim',
                'nim' => '362155401192',
                'email' => 'lukman.hakim@example.com',
                'prodi' => 'Sarjana Terapan Manajemen Bisnis Pariwisata',
                'ukt_awal' => 2500000,
                'pekerjaan_ayah' => 'Nelayan',
                'penghasilan_ayah' => 1100000,
                'pekerjaan_ibu' => 'Pedagang',
                'penghasilan_ibu' => 600000,
                'jumlah_tanggungan' => 3,
                'daya_listrik' => 900,
                'tagihan_listrik' => 80000,
                'tagihan_pdam' => 30000,
                'pbb' => 18000,
                'jumlah_motor' => 1,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'pkh',
                'alasan' => 'Pendapatan gabungan orang tua tidak mencukupi untuk membiayai kuliah saya dan sekolah adik-adik.',
            ],
            [
                'nama' => 'Mega Utami',
                'nim' => '362155401193',
                'email' => 'mega.utami@example.com',
                'prodi' => 'Diploma 3 Teknik Sipil',
                'ukt_awal' => 1500000,
                'pekerjaan_ayah' => 'Pedagang',
                'penghasilan_ayah' => 1500000,
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => 0,
                'jumlah_tanggungan' => 2,
                'daya_listrik' => 900,
                'tagihan_listrik' => 90000,
                'tagihan_pdam' => 35000,
                'pbb' => 22000,
                'jumlah_motor' => 1,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'tidak_ada',
                'alasan' => 'Pendapatan hasil dagang keliling menurun drastis semenjak kenaikan harga bahan pokok.',
            ],
            [
                'nama' => 'Naufal Ariq',
                'nim' => '362155401194',
                'email' => 'naufal.ariq@example.com',
                'prodi' => 'Sarjana Terapan Teknologi Rekayasa Perangkat Lunak',
                'ukt_awal' => 3000000,
                'pekerjaan_ayah' => 'Buruh Harian Lepas',
                'penghasilan_ayah' => 1600000,
                'pekerjaan_ibu' => 'Buruh Harian Lepas',
                'penghasilan_ibu' => 700000,
                'jumlah_tanggungan' => 3,
                'daya_listrik' => 900,
                'tagihan_listrik' => 115000,
                'tagihan_pdam' => 45000,
                'pbb' => 28000,
                'jumlah_motor' => 2,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'SKTM',
                'alasan' => 'Beban ekonomi keluarga sangat berat untuk membayar biaya perkuliahan saya yang tinggi.',
            ],
            [
                'nama' => 'Olivia Nabila',
                'nim' => '362155401195',
                'email' => 'olivia.nabila@example.com',
                'prodi' => 'Sarjana Terapan Destinasi Pariwisata',
                'ukt_awal' => 2000000,
                'pekerjaan_ayah' => 'Petani/Pekebun',
                'penghasilan_ayah' => 900000,
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => 0,
                'jumlah_tanggungan' => 2,
                'daya_listrik' => 450,
                'tagihan_listrik' => 55000,
                'tagihan_pdam' => 0,
                'pbb' => 15000,
                'jumlah_motor' => 1,
                'jumlah_mobil' => 0,
                'kepemilikan_kartu' => 'kip',
                'alasan' => 'Pendapatan bertani jagung sangat kecil dan sering gagal panen karena serangan hama.',
            ],
        ];

        $firstNames = ['Aditya', 'Bella', 'Cahyo', 'Dewi', 'Erwin', 'Fitri', 'Guntur', 'Hani', 'Irfan', 'Julia', 'Kiki', 'Lia', 'Maman', 'Novi', 'Oki', 'Putra', 'Qori', 'Rian', 'Sari', 'Taufik', 'Umar', 'Vina', 'Wawan', 'Yanti', 'Zaki', 'Ari', 'Bagus', 'Candra', 'Dian', 'Endah', 'Feri', 'Galih', 'Hilda', 'Intan', 'Joni', 'Kurnia', 'Laras', 'Murni', 'Nanda', 'Ratih'];
        $lastNames = ['Pratama', 'Hidayah', 'Saputra', 'Ramadhani', 'Wahyuni', 'Setiawan', 'Nugroho', 'Budiman', 'Kusuma', 'Gunawan', 'Siregar', 'Lubis', 'Nasution', 'Tanjung', 'Harahap', 'Wibowo', 'Purnomo', 'Sanjaya', 'Suhendra', 'Subagyo', 'Hartono', 'Purnamasari', 'Lestari', 'Kartikasari', 'Anggraini'];

        $pekerjaanList = [
            'Buruh Harian Lepas' => [500000, 1500000],
            'Petani/Pekebun' => [400000, 1200000],
            'Nelayan' => [600000, 1400000],
            'Wiraswasta' => [1000000, 3000000],
            'Pedagang' => [800000, 2000000],
            'PNS' => [3000000, 5000000],
            'Tidak Bekerja' => [0, 0]
        ];

        $kartuList = ['kip', 'pkh', 'KKS', 'SKTM', 'tidak_ada'];
        
        $alasanTemplates = [
            "Pendapatan orang tua tidak mencukupi untuk membiayai kuliah karena adanya kebutuhan hidup yang mendesak.",
            "Usaha keluarga sedang sepi akibat persaingan pasar yang semakin ketat.",
            "Orang tua sudah lanjut usia dan sering jatuh sakit, sehingga tidak bisa bekerja secara maksimal.",
            "Tanggungan keluarga sangat berat dengan adanya saudara kandung yang masih sekolah.",
            "Gaji orang tua sebagai buruh harian tidak menentu dan sering kali tidak mencukupi kebutuhan bulanan.",
            "Hasil panen pertanian musim ini gagal total akibat serangan hama dan cuaca yang tidak menentu.",
            "Kondisi keuangan keluarga menurun pasca musibah yang menimpa tempat usaha orang tua.",
            "Ayah merupakan satu-satunya tulang punggung keluarga dan saat ini sedang mengalami peningkatan beban cicilan.",
            "Biaya operasional melaut yang tinggi tidak sebanding dengan hasil tangkapan ikan yang didapatkan akhir-akhir ini."
        ];

        // Query all prodi names from DB
        $allProdis = DB::table('prodi')->pluck('nama')->toArray();
        if (empty($allProdis)) {
            $allProdis = ['Sarjana Terapan Teknologi Rekayasa Perangkat Lunak'];
        }

        // Generate 120 more records
        for ($i = 0; $i < 120; $i++) {
            $nama = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
            $nim = '362155401' . str_pad(196 + $i, 3, '0', STR_PAD_LEFT);
            $email = strtolower(str_replace([' ', "'"], ['.', ''], $nama)) . '.' . rand(10, 99) . '@example.com';
            $prodi = $allProdis[array_rand($allProdis)];
            
            $uktAwal = [1500000, 2000000, 2500000, 3000000, 4000000][rand(0, 4)];
            
            $pAyah = array_rand($pekerjaanList);
            $gAyah = rand($pekerjaanList[$pAyah][0], $pekerjaanList[$pAyah][1]);
            
            $pIbu = rand(0, 4) === 0 ? array_rand($pekerjaanList) : 'Ibu Rumah Tangga';
            if ($pIbu === 'Ibu Rumah Tangga' || $pIbu === 'Tidak Bekerja') {
                $gIbu = 0;
            } else {
                $gIbu = rand($pekerjaanList[$pIbu][0], $pekerjaanList[$pIbu][1]);
            }
            
            $tanggungan = rand(1, 5);
            
            $daya = [450, 900, 1300, 2200][rand(0, 3)];
            if ($daya == 450) {
                $tagihanListrik = rand(30000, 70000);
            } elseif ($daya == 900) {
                $tagihanListrik = rand(70000, 150000);
            } elseif ($daya == 1300) {
                $tagihanListrik = rand(120000, 250000);
            } else {
                $tagihanListrik = rand(200000, 450000);
            }
            
            $pdam = rand(0, 3) === 0 ? 0 : rand(25000, 90000);
            $pbb = rand(0, 3) === 0 ? 0 : rand(10000, 75000);
            
            $motor = rand(0, 3);
            $mobil = $motor >= 2 ? rand(0, 1) : 0;
            
            $kartu = $kartuList[array_rand($kartuList)];
            $alasan = $alasanTemplates[array_rand($alasanTemplates)];
            
            $mahasiswaData[] = [
                'nama' => $nama,
                'nim' => $nim,
                'email' => $email,
                'prodi' => $prodi,
                'ukt_awal' => $uktAwal,
                'pekerjaan_ayah' => $pAyah,
                'penghasilan_ayah' => $gAyah,
                'pekerjaan_ibu' => $pIbu,
                'penghasilan_ibu' => $gIbu,
                'jumlah_tanggungan' => $tanggungan,
                'daya_listrik' => $daya,
                'tagihan_listrik' => $tagihanListrik,
                'tagihan_pdam' => $pdam,
                'pbb' => $pbb,
                'jumlah_motor' => $motor,
                'jumlah_mobil' => $mobil,
                'kepemilikan_kartu' => $kartu,
                'alasan' => $alasan,
            ];
        }

        foreach ($mahasiswaData as $key => $data) {
            // Get prodi ID
            $prodiId = DB::table('prodi')->where('nama', $data['prodi'])->value('id');
            if (!$prodiId) {
                // fallback to first prodi
                $prodiId = DB::table('prodi')->first()->id;
            }

            // 1. Create User
            $userId = DB::table('users')->insertGetId([
                'name' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make('12345'),
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Create Mahasiswa Profile
            $mahasiswaId = DB::table('mahasiswa')->insertGetId([
                'user_id' => $userId,
                'nim' => $data['nim'],
                'nama_lengkap' => $data['nama'],
                'prodi_id' => $prodiId,
                'jalur_masuk' => 'SBMPTN',
                'no_hp' => '0812' . rand(10000000, 99999999),
                'semester_saat_ini' => 3,
                'ukt_awal' => $data['ukt_awal'],
                'piutang_semester_lalu' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3. Create Pengajuan Penurunan UKT
            $pengajuanId = DB::table('pengajuan_penurunan_ukt')->insertGetId([
                'mahasiswa_id' => $mahasiswaId,
                'kode' => 'PRN' . str_pad($key + 1, 3, '0', STR_PAD_LEFT),
                'pekerjaan_ayah' => $data['pekerjaan_ayah'],
                'penghasilan_ayah' => $data['penghasilan_ayah'],
                'pekerjaan_ibu' => $data['pekerjaan_ibu'],
                'penghasilan_ibu' => $data['penghasilan_ibu'],
                'total_gaji' => $data['penghasilan_ayah'] + $data['penghasilan_ibu'],
                'jumlah_tanggungan' => $data['jumlah_tanggungan'],
                'daya_listrik' => $data['daya_listrik'],
                'tagihan_listrik' => $data['tagihan_listrik'],
                'tagihan_pdam' => $data['tagihan_pdam'],
                'pbb' => $data['pbb'],
                'jumlah_motor' => $data['jumlah_motor'],
                'jumlah_mobil' => $data['jumlah_mobil'],
                'kepemilikan_kartu' => $data['kepemilikan_kartu'],
                'alasan_pengajuan' => $data['alasan'],
                'link_drive' => 'https://drive.google.com/drive/folders/' . Str::random(30),
                'status' => ($key % 3 === 0) ? 'diajukan' : (($key % 3 === 1) ? 'diterima_keuangan' : 'dinilai_keuangan'),
                'created_at' => now()->subDays(rand(1, 10)),
                'updated_at' => now(),
            ]);

            // 4. Create Random Dokumen Pendukung
            $dokumenTypes = [
                ['jenis' => 'foto_rumah', 'name' => 'Foto Rumah Depan'],
                ['jenis' => 'foto_mobil', 'name' => 'Foto Garasi / Kondisi Transportasi'],
                ['jenis' => 'foto_motor', 'name' => 'Foto Kendaraan Roda Dua'],
                ['jenis' => 'tagihan_listrik', 'name' => 'Bukti Pembayaran Tagihan Listrik'],
            ];

            foreach ($dokumenTypes as $doc) {
                DB::table('dokumen_pendukung')->insert([
                    'pengajuan_id' => $pengajuanId,
                    'jenis_dokumen' => $doc['jenis'],
                    'keterangan' => $doc['name'] . ' ' . $data['nama'],
                    'path' => 'dokumen-pendukung/dummy.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
