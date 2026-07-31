<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FixDataCommand extends Command
{
    protected $signature = 'app:fix-data';
    protected $description = 'Hapus user Leoni Agustin & Ali Fatur Rosidah beserta pengajuannya, dan buat admin jurusan';

    public function handle()
    {
        // ======================================================
        // 1. Hapus data pengajuan + mahasiswa + user
        //    untuk "Leoni Agustin" (id:7) dan "Ali Fatur Rosidah" (id:6)
        // ======================================================

        $targetUserIds = [6, 7]; // Ali Fatur Rosidah, Leoni Agustin

        $mahasiswaIds = DB::table('mahasiswa')
            ->whereIn('user_id', $targetUserIds)
            ->pluck('id')
            ->toArray();

        $this->info("Mahasiswa IDs: " . implode(', ', $mahasiswaIds));

        if (!empty($mahasiswaIds)) {
            $pengajuanIds = DB::table('pengajuan_penurunan_ukt')
                ->whereIn('mahasiswa_id', $mahasiswaIds)
                ->pluck('id')
                ->toArray();

            $this->info("Pengajuan IDs: " . implode(', ', $pengajuanIds));

            if (!empty($pengajuanIds)) {
                DB::table('hasil_validasi')->whereIn('pengajuan_id', $pengajuanIds)->delete();
                $this->line("  [OK] Deleted hasil_validasi");

                DB::table('dokumen_pendukung')->whereIn('pengajuan_id', $pengajuanIds)->delete();
                $this->line("  [OK] Deleted dokumen_pendukung");

                DB::table('point_pengajuan')->whereIn('pengajuan_id', $pengajuanIds)->delete();
                $this->line("  [OK] Deleted point_pengajuan");

                DB::table('pengajuan_penurunan_ukt')->whereIn('id', $pengajuanIds)->delete();
                $this->line("  [OK] Deleted pengajuan_penurunan_ukt");
            }

            DB::table('mahasiswa')->whereIn('id', $mahasiswaIds)->delete();
            $this->line("  [OK] Deleted mahasiswa");
        }

        DB::table('users')->whereIn('id', $targetUserIds)->delete();
        $this->info("Berhasil hapus user: Ali Fatur Rosidah & Leoni Agustin");

        // ======================================================
        // 2. Buat admin jurusan sesuai data jurusan di database
        // ======================================================

        $adminJurusanMap = [
            'Bisnis dan Informatika' => 'admin.bisnis@example.com',
            'Manajemen Pariwisata'   => 'admin.pariwisata@example.com',
            'Pertanian'              => 'admin.pertanian@example.com',
            'Mesin'                  => 'admin.mesin@example.com',
            'Teknik Sipil'           => 'admin.sipil@example.com',
        ];

        $this->newLine();
        $this->info("Membuat admin jurusan...");

        foreach ($adminJurusanMap as $namaJurusan => $email) {
            $jurusan = DB::table('jurusan')->where('nama', $namaJurusan)->first();

            if (!$jurusan) {
                $this->warn("  [SKIP] Jurusan '{$namaJurusan}' tidak ditemukan");
                continue;
            }

            $existing = DB::table('users')
                ->where('role', 'admin')
                ->where('jurusan_id', $jurusan->id)
                ->first();

            if ($existing) {
                $this->warn("  [SKIP] Admin {$namaJurusan} sudah ada: {$existing->email}");
                continue;
            }

            DB::table('users')->insert([
                'name'       => 'Admin ' . $namaJurusan,
                'email'      => $email,
                'password'   => Hash::make('12345'),
                'role'       => 'admin',
                'jurusan_id' => $jurusan->id,
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->line("  [OK] Dibuat admin untuk {$namaJurusan} | email: {$email} | password: 12345");
        }

        $this->newLine();
        $this->info("Daftar semua admin sekarang:");
        $admins = DB::table('users')
            ->leftJoin('jurusan', 'users.jurusan_id', '=', 'jurusan.id')
            ->where('users.role', 'admin')
            ->get(['users.id', 'users.name', 'users.email', 'jurusan.nama as nama_jurusan', 'users.status']);

        $rows = [];
        foreach ($admins as $a) {
            $rows[] = [$a->id, $a->name, $a->email, $a->nama_jurusan ?? '(Global)', $a->status];
        }
        $this->table(['ID', 'Nama', 'Email', 'Jurusan', 'Status'], $rows);

        $this->info("Selesai!");
        return 0;
    }
}
