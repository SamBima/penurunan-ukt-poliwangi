<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanPenurunanUkt;
use App\Models\SkPenurunanUkt;
use App\Models\HasilValidasi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        $keputusanTerbaru = PengajuanPenurunanUkt::with([
            'mahasiswa.prodi',
            'hasilValidasi' => function($query) {
                $query->whereHas('validator', function($q) {
                    $q->where('role', 'wadir');
                })->with('validator');
            }
        ])
        ->where('status', 'dinilai_wadir')
        ->orderBy('updated_at', 'desc')
        ->limit(5)
        ->get();

        $skTerbaru = SkPenurunanUkt::orderBy('tahun', 'desc')
                                   ->orderBy('tanggal_terbit', 'desc')
                                   ->get();

        $stats = $this->getStatsByRole($role);

        return view('dashboard.index', compact('keputusanTerbaru', 'skTerbaru', 'stats', 'role'));
    }

    private function getStatsByRole($role)
    {
        $stats = [];

        if ($role === 'mahasiswa') {
            $mahasiswa = Auth::user()->mahasiswa;

            $stats['total_pengajuan'] = PengajuanPenurunanUkt::where('mahasiswa_id', $mahasiswa->id)->count();
            $stats['pengajuan_diproses'] = PengajuanPenurunanUkt::where('mahasiswa_id', $mahasiswa->id)
                ->whereIn('status', ['diajukan', 'diterima_keuangan', 'dinilai_admin', 'dinilai_keuangan'])
                ->count();
            $stats['pengajuan_disetujui'] = PengajuanPenurunanUkt::where('mahasiswa_id', $mahasiswa->id)
                ->where('status', 'dinilai_wadir')
                ->count();
            $stats['pengajuan_ditolak'] = PengajuanPenurunanUkt::where('mahasiswa_id', $mahasiswa->id)
                ->where('status', 'ditolak')
                ->count();
        } elseif ($role === 'admin') {
            $stats['belum_dinilai'] = PengajuanPenurunanUkt::where('status', 'diterima_keuangan')->count();
            $stats['sudah_dinilai'] = PengajuanPenurunanUkt::where('status', 'dinilai_admin')->count();
            $stats['total_pengajuan'] = PengajuanPenurunanUkt::whereIn('status', ['diterima_keuangan', 'dinilai_admin', 'dinilai_keuangan', 'dinilai_wadir'])->count();
        } elseif ($role === 'keuangan') {
            $stats['menunggu_validasi'] = PengajuanPenurunanUkt::where('status', 'diajukan')->count();
            $stats['belum_dinilai'] = PengajuanPenurunanUkt::where('status', 'dinilai_admin')->count();
            $stats['sudah_dinilai'] = PengajuanPenurunanUkt::where('status', 'dinilai_keuangan')->count();
            $stats['total_sk'] = SkPenurunanUkt::count();
        } elseif ($role === 'wadir') {
            $stats['menunggu_keputusan'] = PengajuanPenurunanUkt::where('status', 'dinilai_keuangan')->count();
            $stats['sudah_diputuskan'] = PengajuanPenurunanUkt::where('status', 'dinilai_wadir')->count();
            $stats['total_pengajuan'] = PengajuanPenurunanUkt::whereIn('status', ['dinilai_keuangan', 'dinilai_wadir'])->count();
        }

        return $stats;
    }
}
