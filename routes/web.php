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
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
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

            Route::get('/riwayat-pengajuan', [PengajuanController::class, 'riwayat'])->name('riwayat-pengajuan');
        });

        Route::middleware(['checkRole:admin,keuangan,wadir'])->group(function () {

            Route::get('/list-pengajuan', [PengajuanController::class, 'index'])->name('list-pengajuan');

            Route::get('/hasil-akhir-pengajuan', [PengajuanController::class, 'hasilAkhir'])
                ->name('hasil-akhir-pengajuan')
                ->middleware(['auth', 'checkRole:keuangan']);

            Route::get('/hasil-akhir-pengajuan/cetak', [PengajuanController::class, 'cetakHasilAkhir'])
                ->name('hasil-akhir-pengajuan.cetak')
                ->middleware(['auth', 'checkRole:keuangan']);

            Route::post('/list-pengajuan/bulk-keuangan', [PengajuanController::class, 'bulkKeuangan'])
                ->name('list-pengajuan.bulk-keuangan')
                ->middleware(['auth', 'checkRole:keuangan']);

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

            Route::get('/arsip-pengajuan', [PengajuanController::class, 'arsip'])->name('arsip-pengajuan');
        });
    });
});

