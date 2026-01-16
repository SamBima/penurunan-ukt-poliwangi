<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HasilValidasi;
use App\Models\PointPengajuan;
use App\Models\DokumenPendukung;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanPenurunanUkt;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    public function pengajuan(Request $request)
    {
        $validated = $request->validate([
            // Data Orang Tua
            'penghasilan_ayah' => 'required|integer|min:0',
            'pekerjaan_ayah' => 'required|string|max:255',
            'penghasilan_ibu' => 'required|integer|min:0',
            'pekerjaan_ibu' => 'required|string|max:255',
            'total_gaji' => 'required|integer|min:0',
            'jumlah_tanggungan' => 'required|integer|min:0',

            // Data Rumah & Utilities
            'daya_listrik' => 'required|integer|min:0',
            'tagihan_listrik' => 'required|integer|min:0',
            'tagihan_pdam' => 'required|integer|min:0',
            'pbb' => 'required|integer|min:0',

            // Data Kendaraan
            'jumlah_motor' => 'required|integer|min:0',
            'jumlah_mobil' => 'required|integer|min:0',

            // Data Tambahan
            'kepemilikan_kartu' => 'required|in:KIP,SKTM,KKS,Tidak Ada',
            'pernyataan_teman' => 'required|in:Ada,Tidak Ada',
            'alasan_pengajuan' => 'required|string|min:10',
            'link_drive' => 'required|url',

            // Dokumen Pendukung
            'dokumen' => 'required|array|min:4',
            'dokumen.*.jenis' => 'required|string',
            'dokumen.*.keterangan' => 'nullable|string|max:255',
            'dokumen.*.file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'penghasilan_ayah.required' => 'Penghasilan ayah wajib diisi.',
            'penghasilan_ayah.integer' => 'Penghasilan ayah harus berupa angka.',
            'penghasilan_ayah.min' => 'Penghasilan ayah tidak boleh negatif.',

            'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib diisi.',
            'pekerjaan_ayah.max' => 'Pekerjaan ayah maksimal 255 karakter.',

            'penghasilan_ibu.required' => 'Penghasilan ibu wajib diisi.',
            'penghasilan_ibu.integer' => 'Penghasilan ibu harus berupa angka.',
            'penghasilan_ibu.min' => 'Penghasilan ibu tidak boleh negatif.',

            'pekerjaan_ibu.required' => 'Pekerjaan ibu wajib diisi.',
            'pekerjaan_ibu.max' => 'Pekerjaan ibu maksimal 255 karakter.',

            'total_gaji.required' => 'Total gaji keluarga wajib diisi.',
            'total_gaji.integer' => 'Total gaji keluarga harus berupa angka.',
            'total_gaji.min' => 'Total gaji keluarga tidak boleh negatif.',

            'jumlah_tanggungan.required' => 'Jumlah tanggungan wajib diisi.',
            'jumlah_tanggungan.integer' => 'Jumlah tanggungan harus berupa angka.',
            'jumlah_tanggungan.min' => 'Jumlah tanggungan tidak boleh negatif.',

            'daya_listrik.required' => 'Daya listrik wajib diisi.',
            'daya_listrik.integer' => 'Daya listrik harus berupa angka.',
            'daya_listrik.min' => 'Daya listrik tidak boleh negatif.',

            'tagihan_listrik.required' => 'Tagihan listrik wajib diisi.',
            'tagihan_listrik.integer' => 'Tagihan listrik harus berupa angka.',
            'tagihan_listrik.min' => 'Tagihan listrik tidak boleh negatif.',

            'tagihan_pdam.required' => 'Tagihan PDAM wajib diisi.',
            'tagihan_pdam.integer' => 'Tagihan PDAM harus berupa angka.',
            'tagihan_pdam.min' => 'Tagihan PDAM tidak boleh negatif.',

            'pbb.required' => 'PBB wajib diisi.',
            'pbb.integer' => 'PBB harus berupa angka.',
            'pbb.min' => 'PBB tidak boleh negatif.',

            'jumlah_motor.required' => 'Jumlah motor wajib diisi.',
            'jumlah_motor.integer' => 'Jumlah motor harus berupa angka.',
            'jumlah_motor.min' => 'Jumlah motor tidak boleh negatif.',

            'jumlah_mobil.required' => 'Jumlah mobil wajib diisi.',
            'jumlah_mobil.integer' => 'Jumlah mobil harus berupa angka.',
            'jumlah_mobil.min' => 'Jumlah mobil tidak boleh negatif.',

            'kepemilikan_kartu.required' => 'Kepemilikan kartu bantuan wajib dipilih.',
            'kepemilikan_kartu.in' => 'Pilihan kepemilikan kartu tidak valid.',

            'pernyataan_teman.required' => 'Pernyataan dari teman wajib dipilih.',
            'pernyataan_teman.in' => 'Pilihan pernyataan teman tidak valid.',

            'alasan_pengajuan.required' => 'Alasan pengajuan wajib diisi.',
            'alasan_pengajuan.min' => 'Alasan pengajuan minimal 10 karakter.',

            'link_drive.required' => 'Link Google Drive wajib diisi.',
            'link_drive.url' => 'Format URL tidak valid.',

            'dokumen.required' => 'Dokumen pendukung wajib diupload.',
            'dokumen.min' => 'Minimal 4 dokumen pendukung harus diupload.',
            'dokumen.*.jenis.required' => 'Jenis dokumen wajib diisi.',
            'dokumen.*.file.required' => 'File dokumen wajib diupload.',
            'dokumen.*.file.mimes' => 'File harus berformat: jpg, jpeg, png, atau pdf.',
            'dokumen.*.file.max' => 'Ukuran file maksimal 5MB.',
        ]);

        if ($validated['total_gaji'] != ($validated['penghasilan_ayah'] + $validated['penghasilan_ibu'])) {
            return back()->withErrors(['total_gaji' => 'Total gaji tidak sesuai dengan penjumlahan penghasilan ayah dan ibu.'])
                        ->withInput();
        }

        $dokumenWajib = ['foto_rumah', 'foto_mobil', 'foto_motor', 'tagihan_listrik'];
        $dokumenJenis = collect($validated['dokumen'])->pluck('jenis')->toArray();

        foreach ($dokumenWajib as $jenis) {
            if (!in_array($jenis, $dokumenJenis)) {
                return back()->withErrors(['dokumen' => "Dokumen {$jenis} wajib diupload."])
                            ->withInput();
            }
        }

        $existingPengajuan = PengajuanPenurunanUkt::where('mahasiswa_id', Mahasiswa::where('user_id', Auth::id())->first()->id)
                                                  ->whereIn('status', ['diajukan', 'diterima_keuangan', 'dinilai_admin', 'dinilai_keuangan', 'dinilai_wadir'])
                                                  ->first();

        if ($existingPengajuan) {
            return back()->withErrors([
                'error' => "Anda masih memiliki pengajuan yang sedang diproses dengan kode: {$existingPengajuan->kode}. " .
                          "Silakan tunggu hingga proses selesai sebelum mengajukan yang baru."
            ]);
        }

        DB::beginTransaction();

        try {
            $pengajuan = PengajuanPenurunanUkt::create([
                'mahasiswa_id' => Mahasiswa::where('user_id', Auth::id())->value('id'),
                'penghasilan_ayah' => $validated['penghasilan_ayah'],
                'pekerjaan_ayah' => $validated['pekerjaan_ayah'],
                'penghasilan_ibu' => $validated['penghasilan_ibu'],
                'pekerjaan_ibu' => $validated['pekerjaan_ibu'],
                'total_gaji' => $validated['total_gaji'],
                'jumlah_tanggungan' => $validated['jumlah_tanggungan'],
                'daya_listrik' => $validated['daya_listrik'],
                'tagihan_listrik' => $validated['tagihan_listrik'],
                'tagihan_pdam' => $validated['tagihan_pdam'],
                'pbb' => $validated['pbb'],
                'jumlah_motor' => $validated['jumlah_motor'],
                'jumlah_mobil' => $validated['jumlah_mobil'],
                'kepemilikan_kartu' => $validated['kepemilikan_kartu'],
                'pernyataan_teman' => $validated['pernyataan_teman'],
                'alasan_pengajuan' => $validated['alasan_pengajuan'],
                'link_drive' => $validated['link_drive'],
                'status' => 'diajukan',
            ]);

            foreach ($validated['dokumen'] as $dokumenData) {
                if (isset($dokumenData['file'])) {
                    $file = $dokumenData['file'];

                    $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                    $path = $file->storeAs('dokumen-pendukung/' . $pengajuan->id, $fileName, 'public');

                    DokumenPendukung::create([
                        'pengajuan_id' => $pengajuan->id,
                        'jenis_dokumen' => $dokumenData['jenis'],
                        'keterangan' => $dokumenData['keterangan'] ?? null,
                        'path' => $path,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success',
                "Pengajuan penurunan UKT berhasil diajukan dengan kode: {$pengajuan->kode}. " .
                "Silakan pantau status pengajuan Anda secara berkala."
            );

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error saat mengajukan penurunan UKT: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengajukan penurunan UKT. Silakan coba lagi.'])
                        ->withInput();
        }
    }

    public function approvePengajuan($kode)
    {
        try {
            $pengajuan = PengajuanPenurunanUkt::where('kode', $kode)->firstOrFail();

            if ($pengajuan->status !== 'diajukan') {
                return redirect()->back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
            }

            $pengajuan->update(['status' => 'diterima_keuangan']);

            return redirect()->back()->with('success', 'Pengajuan berhasil diterima dan dapat diproses oleh Kajur.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function rejectPengajuan(Request $request, $kode)
    {
        try {
            $pengajuan = PengajuanPenurunanUkt::where('kode', $kode)->firstOrFail();

            if ($pengajuan->status !== 'diajukan') {
                return redirect()->back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
            }

            $pengajuan->update(['status' => 'ditolak']);

            return redirect()->back()->with('success', 'Pengajuan berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function validasi(Request $request, $kode)
    {
        $user = Auth::user();
        $role = $user->role;

        if ($role === 'admin') {
            return $this->validasiAdmin($request, $kode);
        } elseif ($role === 'keuangan') {
            return $this->validasiKeuangan($request, $kode);
        } elseif ($role === 'wadir') {
            return $this->validasiWadir($request, $kode);
        } else {
            return redirect()->back()->with('error', 'Role tidak dikenali');
        }
    }

    private function validasiAdmin(Request $request, $kode)
    {
        $request->validate([
            'pengajuan_id' => 'required|exists:pengajuan_penurunan_ukt,id',
            'poin_penghasilan_ortu' => 'required|integer|min:0|max:100',
            'poin_tagihan' => 'required|integer|min:0|max:100',
            'poin_kepemilikan' => 'required|integer|min:0|max:100',
            'poin_kondisi_rumah' => 'required|integer|min:0|max:100',
            'poin_kartu_bantuan' => 'required|integer|min:0|max:100',
            'poin_pernyataan_teman' => 'required|integer|min:0|max:100',
            'hasil_wawancara' => 'nullable|string|max:1000',
            'rekomendasi_ukt' => 'required|integer|min:0|max:7',
            'status' => 'required|in:disetujui,disarankan_cicilan'
        ]);

        try {
            DB::beginTransaction();

            $pengajuan = PengajuanPenurunanUkt::with('mahasiswa')->findOrFail($request->pengajuan_id);

            if ($pengajuan->kode !== $kode) {
                throw new \Exception('Kode pengajuan tidak sesuai');
            }

            $this->validateAccess($pengajuan, 'admin');

            $pointPengajuan = PointPengajuan::create([
                'pengajuan_id' => $request->pengajuan_id,
                'user_id' => Auth::id(),
                'role' => 'admin',
                'poin_penghasilan_ortu' => $request->poin_penghasilan_ortu,
                'poin_tagihan' => $request->poin_tagihan,
                'poin_kepemilikan' => $request->poin_kepemilikan,
                'poin_kondisi_rumah' => $request->poin_kondisi_rumah,
                'poin_kartu_bantuan' => $request->poin_kartu_bantuan,
                'poin_pernyataan_teman' => $request->poin_pernyataan_teman,
            ]);

            $uktBaru = $this->calculateNewUkt($pengajuan->mahasiswa, $request->rekomendasi_ukt);

            HasilValidasi::create([
                'pengajuan_id' => $request->pengajuan_id,
                'user_id' => Auth::id(),
                'catatan' => '-',
                'hasil_wawancara' => $request->hasil_wawancara,
                'hasil_score' => $pointPengajuan->total_poin,
                'rekomendasi_ukt' => $uktBaru,
                'status' => $request->status,
            ]);

            $pengajuan->update(['status' => 'dinilai_admin']);

            DB::commit();

            return redirect()
                ->route('list-pengajuan.show', $kode)
                ->with('success', 'Hasil penilaian berhasil disimpan! Total poin: ' . $pointPengajuan->total_poin);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function validasiKeuangan(Request $request, $kode)
    {
        $request->validate([
            'pengajuan_id' => 'required|exists:pengajuan_penurunan_ukt,id',
            'poin_penghasilan_ortu' => 'required|integer|min:0|max:100',
            'poin_tagihan' => 'required|integer|min:0|max:100',
            'poin_kepemilikan' => 'required|integer|min:0|max:100',
            'poin_kondisi_rumah' => 'required|integer|min:0|max:100',
            'poin_kartu_bantuan' => 'required|integer|min:0|max:100',
            'poin_pernyataan_teman' => 'required|integer|min:0|max:100',
            'poin_jumlah_tanggungan' => 'required|integer|min:0|max:50',
            'poin_daya_listrik' => 'required|integer|min:0|max:50',
            'poin_pbb' => 'required|integer|min:0|max:50',
            'poin_wawancara' => 'required|integer|min:0|max:50',
            'hasil_wawancara' => 'nullable|string|max:1000',
            'rekomendasi_ukt' => 'required|integer|min:0|max:7',
            'status' => 'required|in:disetujui,disarankan_cicilan'
        ]);

        try {
            DB::beginTransaction();

            $pengajuan = PengajuanPenurunanUkt::with('mahasiswa')->findOrFail($request->pengajuan_id);

            if ($pengajuan->kode !== $kode) {
                throw new \Exception('Kode pengajuan tidak sesuai');
            }

            $this->validateAccess($pengajuan, 'keuangan');

            $pointPengajuan = PointPengajuan::create([
                'pengajuan_id' => $request->pengajuan_id,
                'user_id' => Auth::id(),
                'role' => 'keuangan',
                'poin_penghasilan_ortu' => $request->poin_penghasilan_ortu,
                'poin_tagihan' => $request->poin_tagihan,
                'poin_kepemilikan' => $request->poin_kepemilikan,
                'poin_kondisi_rumah' => $request->poin_kondisi_rumah,
                'poin_kartu_bantuan' => $request->poin_kartu_bantuan,
                'poin_pernyataan_teman' => $request->poin_pernyataan_teman,
                'poin_jumlah_tanggungan' => $request->poin_jumlah_tanggungan,
                'poin_daya_listrik' => $request->poin_daya_listrik,
                'poin_pbb' => $request->poin_pbb,
                'poin_wawancara' => $request->poin_wawancara,
            ]);

            $uktBaru = $this->calculateNewUkt($pengajuan->mahasiswa, $request->rekomendasi_ukt);

            HasilValidasi::create([
                'pengajuan_id' => $request->pengajuan_id,
                'user_id' => Auth::id(),
                'catatan' => '-',
                'hasil_wawancara' => $request->hasil_wawancara,
                'hasil_score' => $pointPengajuan->total_poin,
                'rekomendasi_ukt' => $uktBaru,
                'status' => $request->status,
            ]);

            $pengajuan->update(['status' => 'dinilai_keuangan']);

            DB::commit();

            return redirect()
                ->route('list-pengajuan.show', $kode)
                ->with('success', 'Hasil penilaian berhasil disimpan! Total poin: ' . $pointPengajuan->total_poin);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function validasiWadir(Request $request, $kode)
    {
        $request->validate([
            'pengajuan_id' => 'required|exists:pengajuan_penurunan_ukt,id',
            'status' => 'required|in:disetujui,disarankan_cicilan',
            'rekomendasi_ukt' => 'required|integer|min:0|max:7',
            'berlaku_selama' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $pengajuan = PengajuanPenurunanUkt::with('mahasiswa')->findOrFail($request->pengajuan_id);

            if ($pengajuan->kode !== $kode) {
                throw new \Exception('Kode pengajuan tidak sesuai');
            }

            $this->validateAccess($pengajuan, 'wadir');

            $validasiKeuangan = HasilValidasi::where('pengajuan_id', $pengajuan->id)
                ->whereHas('validator', function($q) {
                    $q->where('role', 'keuangan');
                })
                ->first();

            if (!$validasiKeuangan) {
                throw new \Exception('Belum ada validasi dari Keuangan');
            }

            $uktBaru = $this->calculateNewUkt($pengajuan->mahasiswa, $request->rekomendasi_ukt);

            HasilValidasi::create([
                'pengajuan_id' => $request->pengajuan_id,
                'user_id' => Auth::id(),
                'catatan' => '-',
                'hasil_wawancara' => '-',
                'hasil_score' => 0,
                'rekomendasi_ukt' => $uktBaru,
                'status' => $request->status,
                'berlaku_selama' => $request->berlaku_selama,
            ]);

            $pengajuan->update(['status' => 'dinilai_wadir']);

            DB::commit();

            return redirect()
                ->route('list-pengajuan.show', $kode)
                ->with('success', 'Keputusan Wadir berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function validateAccess($pengajuan, $role)
    {
        $allowedStatuses = [
            'admin' => ['diterima_keuangan', 'dinilai_admin'],
            'keuangan' => ['dinilai_admin', 'dinilai_keuangan'],
            'wadir' => ['dinilai_keuangan', 'dinilai_wadir']
        ];

        if (!isset($allowedStatuses[$role])) {
            throw new \Exception('Role tidak dikenali');
        }

        if (!in_array($pengajuan->status, $allowedStatuses[$role])) {
            throw new \Exception('Anda tidak memiliki akses untuk memvalidasi pengajuan dengan status ini');
        }

        $existingValidation = HasilValidasi::where('pengajuan_id', $pengajuan->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingValidation) {
            throw new \Exception('Anda sudah pernah memvalidasi pengajuan ini');
        }
    }

    private function calculateNewUkt($mahasiswa, $tingkatPenurunan)
    {
        $tingkatUkt = [
            1 => 7000000,
            2 => 5000000,
            3 => 4000000,
            4 => 3000000,
            5 => 2000000,
            6 => 1000000,
            7 => 500000,
        ];

        $uktSaatIni = $mahasiswa->ukt_awal;

        if ($tingkatPenurunan == 0) {
            return $uktSaatIni;
        }

        $tingkatSaatIni = array_search($uktSaatIni, $tingkatUkt, true);

        if ($tingkatSaatIni === false) {
            $tingkatSaatIni = 1;
        }

        $tingkatBaru = $tingkatSaatIni + $tingkatPenurunan;
        $tingkatBaru = max(1, min(7, $tingkatBaru));

        return $tingkatUkt[$tingkatBaru];
    }

    public function show($kode)
    {
        $pengajuan = PengajuanPenurunanUkt::with([
            'mahasiswa.prodi',
            'dokumenPendukung',
            'hasilValidasi.validator',
            'pointPengajuan'
        ])->where('kode', $kode)->firstOrFail();

        $role = Auth::user()->role;

        $existingPoint = PointPengajuan::where('pengajuan_id', $pengajuan->id)
            ->where('user_id', Auth::id())
            ->where('role', $role)
            ->first();

        $poinAdmin = null;
        $poinKeuangan = null;

        if ($role === 'keuangan' || $role === 'wadir') {
            $poinAdmin = PointPengajuan::where('pengajuan_id', $pengajuan->id)
                ->where('role', 'admin')
                ->first();
        }

        if ($role === 'wadir') {
            $poinKeuangan = PointPengajuan::where('pengajuan_id', $pengajuan->id)
                ->where('role', 'keuangan')
                ->first();
        }

        // Jika status sudah final (Arsip), tampilkan view arsip readonly
        if (in_array($pengajuan->status, ['dinilai_wadir', 'ditolak'])) {
            return view('dashboard.detail_arsip', compact('pengajuan'));
        }

        if ($role === 'admin') {
            return view('dashboard.detail_list_pengajuan_admin', compact('pengajuan', 'existingPoint'));
        } elseif ($role === 'keuangan') {
            return view('dashboard.detail_list_pengajuan_keuangan', compact('pengajuan', 'existingPoint', 'poinAdmin'));
        } elseif ($role === 'wadir') {
            return view('dashboard.detail_list_pengajuan_wadir', compact('pengajuan', 'existingPoint', 'poinAdmin', 'poinKeuangan'));
        } else {
            return view('dashboard.detail_list_pengajuan_admin', compact('pengajuan', 'existingPoint'));
        }
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        
        $query = PengajuanPenurunanUkt::with(['mahasiswa']);

        // Tentukan status yang bisa dilihat berdasarkan role
        $allowedStatuses = [];
        if ($role === 'keuangan') {
            $allowedStatuses = ['diajukan', 'dinilai_admin'];
        } elseif ($role === 'admin') {
            $allowedStatuses = ['diterima_keuangan'];
        } elseif ($role === 'wadir') {
            $allowedStatuses = ['dinilai_keuangan'];
        }

        // Filter berdasarkan role - hanya tampilkan yang perlu ditindaklanjuti
        if (!empty($allowedStatuses)) {
            if ($request->filled('status') && in_array($request->status, $allowedStatuses)) {
                $query->where('status', $request->status);
            } else {
                $query->whereIn('status', $allowedStatuses);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                 $q->where('kode', 'like', "%{$search}%")
                   ->orWhereHas('mahasiswa', function($m) use ($search) {
                       $m->where('nama', 'like', "%{$search}%")
                         ->orWhere('nim', 'like', "%{$search}%");
                   });
            });
        }

        if ($request->filled('semester')) {
            [$semester, $tahun] = explode('_', $request->semester);

            $query->where(function ($q) use ($semester, $tahun) {
                if ($semester === 'ganjil') {
                    $q->whereYear('created_at', $tahun)
                    ->whereBetween(DB::raw('MONTH(created_at)'), [7, 12]);
                } elseif ($semester === 'genap') {
                    $q->whereYear('created_at', $tahun)
                    ->whereBetween(DB::raw('MONTH(created_at)'), [1, 6]);
                }
            });
        }

        $query->orderBy('created_at', 'desc');
        $pengajuan = $query->paginate(10);
        $pengajuan->appends($request->query());

        $firstPengajuan = PengajuanPenurunanUkt::orderBy('created_at', 'asc')->first();
        $startYear = $firstPengajuan ? $firstPengajuan->created_at->year : now()->year;

        $semesterOptions = [];
        $currentYear = now()->year + 1;

        for ($year = $startYear; $year <= $currentYear; $year++) {
            $semesterOptions["ganjil_{$year}"] = "Ganjil {$year}/" . ($year + 1);
            $semesterOptions["genap_{$year}"] = "Genap {$year}/" . ($year + 1);
        }

        // Buat status options berdasarkan role
        $statusOptions = [];
        $statusLabels = [
            'diajukan' => 'Diajukan',
            'diterima_keuangan' => 'Diterima Keuangan',
            'dinilai_admin' => 'Dinilai Kajur',
            'dinilai_keuangan' => 'Dinilai Keuangan',
            'dinilai_wadir' => 'Dinilai Wadir',
        ];

        foreach ($allowedStatuses as $status) {
            if (isset($statusLabels[$status])) {
                $statusOptions[$status] = $statusLabels[$status];
            }
        }

        return view('dashboard.list_pengajuan', compact('pengajuan', 'semesterOptions', 'statusOptions'));
    }

    public function arsip(Request $request)
    {
        $query = PengajuanPenurunanUkt::with(['mahasiswa']);

        // Status Arsip = Selesai (dinilai_wadir menandakan selesai oleh Wadir)
        $arsipStatuses = ['dinilai_wadir', 'ditolak'];
        
        if ($request->filled('status') && in_array($request->status, $arsipStatuses)) {
             $query->where('status', $request->status);
        } else {
             $query->whereIn('status', $arsipStatuses);
        }

        // Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                 $q->where('kode', 'like', "%{$search}%")
                   ->orWhereHas('mahasiswa', function($m) use ($search) {
                       $m->where('nama', 'like', "%{$search}%")
                         ->orWhere('nim', 'like', "%{$search}%");
                   });
            });
        }

        $query->orderBy('created_at', 'desc');
        $pengajuan = $query->paginate(10);
        $pengajuan->appends($request->query());

        $firstPengajuan = PengajuanPenurunanUkt::orderBy('created_at', 'asc')->first();
        $startYear = $firstPengajuan ? $firstPengajuan->created_at->year : now()->year;

        $semesterOptions = [];
        $currentYear = now()->year + 1;
        for ($year = $startYear; $year <= $currentYear; $year++) {
            $semesterOptions["ganjil_{$year}"] = "Ganjil {$year}/" . ($year + 1);
            $semesterOptions["genap_{$year}"] = "Genap {$year}/" . ($year + 1);
        }

        $statusOptions = [
            'dinilai_wadir' => 'Selesai (Keputusan Wadir)',
            'ditolak' => 'Ditolak'
        ];
        
        $isArsip = true;

        return view('dashboard.list_pengajuan', compact('pengajuan', 'semesterOptions', 'statusOptions', 'isArsip'));
    }

    public function riwayat(Request $request)
    {
        $query = PengajuanPenurunanUkt::with([
            'mahasiswa',
            'dokumenPendukung'
        ])
        ->withCount('dokumenPendukung')
        ->where('mahasiswa_id', Mahasiswa::where('user_id', Auth::id())->first()->id)
        ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('kode', 'like', '%' . $request->search . '%');
        }

        $pengajuans = $query->paginate(5)->appends($request->query());

        return view('dashboard.riwayat_pengajuan', compact('pengajuans'));
    }
}
