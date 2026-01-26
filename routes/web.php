<?php

use App\Http\Controllers\AnggotaDokumenKegiatanController;
use App\Http\Controllers\AnggotaIuranController;
use App\Http\Controllers\AnggotaIuranDetailController;
use App\Http\Controllers\AnggotaKasKeluarController;
use App\Http\Controllers\AnggotaLaporanKasController;
use App\Http\Controllers\AnggotaMemberController;
use App\Http\Controllers\AnggotaPemasukanController;
use App\Http\Controllers\AnggotaSertifikatController;
use App\Http\Controllers\AnggotaSuratKeluarController;
use App\Http\Controllers\AnggotaSuratMasukController;
use App\Http\Controllers\DokumenKegiatanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\IuranDetailController;
use App\Http\Controllers\KasKeluarController;
use App\Http\Controllers\LaporanKasController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SertifikatController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CekLevel;
use App\Models\AnggotaSertifikat;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {return view('login');})->name('login');
Route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');
Route::get('/daftar', function () {return view('daftar');})->name('daftar');
Route::post('/postdaftar', [LoginController::class, 'postdaftar'])->name('postdaftar');
Route::post('/postlogout', [LoginController::class, 'postlogout'])->name('logout');

Route::middleware(['auth:user', 'ceklevel:Sekretaris Umum'])->group(function () {
    Route::get('/beranda-sekum', [HomeController::class, 'index'])->name('beranda-sekum');
    // Route::get('/home', [HomeController::class, 'grafiksekum'])->name('home');
    Route::resource('surat-masuk', SuratMasukController::class);
    Route::post('/download(suratmasuk)', [SuratMasukController::class, 'download'])->name('downloadsuratmasuk');
    Route::resource('surat-keluar', SuratKeluarController::class);
    Route::resource('sertifikat', SertifikatController::class);
    Route::resource('dokumen-kegiatan', DokumenKegiatanController::class);
    Route::resource('member', MemberController::class);
    });

Route::middleware(['auth:user', 'ceklevel:Bendahara Umum'])->group(function () {
    Route::get('/beranda-bendum', [HomeController::class, 'bendum'])->name('beranda-bendum');
    Route::resource('iuran', IuranController::class);
    Route::resource('iurandetail', IuranDetailController::class);
    Route::resource('pemasukan', PemasukanController::class);
    Route::resource('kas-keluar', KasKeluarController::class);
    Route::resource('laporan-kas', LaporanKasController::class);
    Route::get(  '/cetak-laporan-kas/{tanggal_awal}/{tanggal_akhir}',  [LaporanKasController::class, 'cetak'])->name('laporan-kas.cetak');
    });

Route::middleware(['auth:anggota', 'ceklevel:Anggota'])->group(function () {
    Route::get('/beranda-anggota', [HomeController::class, 'anggota'])->name('beranda-anggota');
    Route::resource('surat-masuk-anggota', AnggotaSuratMasukController::class);
    Route::resource('surat-keluar-anggota', AnggotaSuratKeluarController::class);
    Route::resource('sertifikat-anggota', AnggotaSertifikatController::class);
    Route::resource('dokumen-kegiatan-anggota', AnggotaDokumenKegiatanController::class);
    Route::resource('iuran-anggota', AnggotaIuranController::class);
    Route::resource('iurandetail-anggota', AnggotaIuranDetailController::class);
    Route::resource('pemasukan-anggota', AnggotaPemasukanController::class);
    Route::resource('kas-keluar-anggota', AnggotaKasKeluarController::class);
    Route::resource('laporan-kas-anggota', AnggotaLaporanKasController::class);
    Route::get(  '/cetak-laporan-kas/{tanggal_awal}/{tanggal_akhir}',  [AnggotaLaporanKasController::class, 'cetak'])->name('laporan-kas-anggota.cetak');
    Route::resource('member-anggota', AnggotaMemberController::class);
    });