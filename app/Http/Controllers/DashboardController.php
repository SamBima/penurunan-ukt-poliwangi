<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanPenurunanUkt;
use App\Models\SkPenurunanUkt;
use App\Models\HasilValidasi;
use Illuminate\Support\Facades\Auth;

use App\Models\Prodi;
use App\Models\Mahasiswa;

class DashboardController extends Controller
{
    public function profile()
    {
        if (Auth::user()->role == 'mahasiswa') {
            $prodi = Prodi::with('jurusan')->get();
            $mahasiswa = Mahasiswa::where('user_id', Auth::user()->id)->first();
            return view('dashboard.profile_mahasiswa', compact('prodi', 'mahasiswa'));
        }

        return view('dashboard.profile');
    }

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
        $user = Auth::user();

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
        } else {
            $queryBase = PengajuanPenurunanUkt::query();

            // Filter berdasarkan jurusan jika user adalah admin (Kajur) dan terikat jurusan
            if ($role === 'admin' && $user->jurusan_id) {
                $queryBase->whereHas('mahasiswa.prodi', function($q) use ($user) {
                    $q->where('jurusan_id', $user->jurusan_id);
                });
            }

            // Tentukan status untuk "Belum Dinilai" (List Pengajuan) dan "Sudah Dinilai" (Arsip)
            $listStatuses = [];
            $arsipStatuses = [];

            if ($role === 'admin') {
                $listStatuses = ['diterima_keuangan'];
                $arsipStatuses = ['dinilai_admin', 'dinilai_keuangan', 'dinilai_wadir', 'ditolak'];
            } elseif ($role === 'keuangan') {
                $listStatuses = ['diajukan', 'dinilai_admin'];
                $arsipStatuses = ['diterima_keuangan', 'dinilai_keuangan', 'dinilai_wadir', 'ditolak'];
            } elseif ($role === 'wadir') {
                $listStatuses = ['dinilai_keuangan'];
                $arsipStatuses = ['dinilai_wadir', 'ditolak'];
            }

            $stats['belum_dinilai'] = (clone $queryBase)->whereIn('status', $listStatuses)->count();
            $stats['sudah_dinilai'] = (clone $queryBase)->whereIn('status', $arsipStatuses)->count();
            $stats['total_pengajuan'] = $stats['belum_dinilai'] + $stats['sudah_dinilai'];
            $stats['total_sk'] = SkPenurunanUkt::count();
        }

        return $stats;
    }
}
