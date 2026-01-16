<?php

use App\Models\Prodi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanPenurunanUkt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SkPenurunanUktController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', function () {
        if (Auth::user()->role == 'mahasiswa') {
            $prodi = Prodi::with('jurusan')->get();
            $mahasiswa = Mahasiswa::where('user_id', Auth::user()->id)->first();
            return view('dashboard.profile_mahasiswa', compact('prodi', 'mahasiswa'));
        }

        return view('dashboard.profile');
    })->name('profile');
    Route::post('/profile-mahasiswa', [AuthController::class, 'profileMahasiswa'])->name('profile-mahasiswa');
    Route::post('/password/update', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::middleware(['hasProfile'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('sk-penurunan-ukt')->name('sk.')->group(function () {
            Route::get('/', [SkPenurunanUktController::class, 'index'])->name('index');
            Route::get('/{id}/download', [SkPenurunanUktController::class, 'download'])->name('download');

            Route::middleware(['checkRole:keuangan,wadir'])->group(function () {
                Route::get('/create', [SkPenurunanUktController::class, 'create'])->name('create');
                Route::post('/', [SkPenurunanUktController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [SkPenurunanUktController::class, 'edit'])->name('edit');
                Route::put('/{id}', [SkPenurunanUktController::class, 'update'])->name('update');
                Route::delete('/{id}', [SkPenurunanUktController::class, 'destroy'])->name('destroy');
            });
        });

        Route::middleware(['checkRole:mahasiswa'])->group(function () {
            Route::get('/pengajuan', function () {
                return view('dashboard.pengajuan');
            })->name('pengajuan');
            Route::post('/pengajuan', [PengajuanController::class, 'pengajuan']);

            Route::get('/riwayat-pengajuan', function (Request $request) {
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
            })->name('riwayat-pengajuan');
        });

        Route::middleware(['checkRole:admin,keuangan,wadir'])->group(function () {

            Route::get('/list-pengajuan', function (Request $request) {
                $query = PengajuanPenurunanUkt::with(['mahasiswa']);

                if ($request->filled('search')) {
                    $query->search($request->search);
                }

                if ($request->filled('status')) {
                    $query->byStatus($request->status);
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

                return view('dashboard.list_pengajuan', compact('pengajuan', 'semesterOptions'));
            })->name('list-pengajuan');

            Route::post('/list-pengajuan/{kode}/approve', [PengajuanController::class, 'approvePengajuan'])
                ->name('list-pengajuan.approve')
                ->middleware(['auth', 'checkRole:keuangan']);

            Route::post('/list-pengajuan/{kode}/reject', [PengajuanController::class, 'rejectPengajuan'])
                ->name('list-pengajuan.reject')
                ->middleware(['auth', 'checkRole:keuangan']);

            Route::post('/list-pengajuan/{kode}/validasi', [PengajuanController::class, 'validasi'])
                ->name('list-pengajuan.validasi')
                ->middleware(['auth', 'checkRole:admin,keuangan,wadir']);

            Route::get('/list-pengajuan/{kode}', [PengajuanController::class, 'show'])
                ->name('list-pengajuan.show')
                ->middleware(['auth', 'checkRole:admin,keuangan,wadir']);
        });
    });
});

