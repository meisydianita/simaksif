<?php

use App\Http\Controllers\AnggotaController;
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
use App\Http\Controllers\DaftarController;
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
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\UserController;

Route::get('/', function () {return view('welcome');});
Route::get('/sihimasif', function () {return view('welcome-himasif');});
Route::get('/login', function () {return view('login');})->name('login');
Route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');
Route::post('/postlogout', [LoginController::class, 'postlogout'])->name('logout');
Route::get('/daftar', function () {return view('anggota.daftar');})->name('daftar');
Route::post('/postdaftar', [DaftarController::class, 'postdaftar'])->name('postdaftar');
Route::get('/reset-kata-sandi', [LoginController::class, 'resetsandi'])->name('reset-kata-sandi');
Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])->name('password.update');


Route::middleware(['auth:user', 'ceklevel:Sekretaris Umum'])->group(function () {
    Route::get('/beranda-sekum', [HomeController::class, 'index'])->name('beranda-sekum');
    Route::resource('surat-masuk', SuratMasukController::class);
    Route::post('/download(suratmasuk)', [SuratMasukController::class, 'download'])->name('downloadsuratmasuk');
    Route::resource('surat-keluar', SuratKeluarController::class);
    Route::resource('sertifikat', SertifikatController::class);
    Route::resource('dokumen-kegiatan', DokumenKegiatanController::class);
    Route::resource('member', MemberController::class);
    Route::get('/profil-sekum', [ProfilController::class, 'sekum'])->name('profil-sekum');
    Route::get('/edit-profil-sekum', [ProfilController::class, 'editsekum'])->name('edit-profil-sekum');
    Route::prefix('sekum')->group(function () {
        Route::resource('user', UserController::class)->names('sekum.user');
    });
    Route::get('/ubah-kata-sandi-sekum', [ProfilController::class, 'passwordsekum'])->name('ubah-sandi-sekum');
    Route::put('/sekum/password', [UserController::class, 'updatePassword'])->name('sekum-update-sandi'); 
    });

Route::middleware(['auth:user', 'ceklevel:Bendahara Umum'])->group(function () {
    Route::get('/beranda-bendum', [HomeController::class, 'bendum'])->name('beranda-bendum');
    Route::resource('iuran', IuranController::class);
    Route::resource('iurandetail', IuranDetailController::class);
    Route::resource('pemasukan', PemasukanController::class);
    Route::resource('kas-keluar', KasKeluarController::class);
    Route::resource('laporan-kas', LaporanKasController::class);
    Route::get(  '/bendum/cetak-laporan-kas/{tanggal_awal}/{tanggal_akhir}',  [LaporanKasController::class, 'cetak'])->name('laporan-kas.cetak');
    Route::get('/profil-bendum', [ProfilController::class, 'bendum'])->name('profil-bendum');
    Route::get('/edit-profil-bendum', [ProfilController::class, 'editbendum'])->name('edit-profil-bendum');
    Route::prefix('bendum')->group(function () {
        Route::resource('user', UserController::class)->names('bendum.user');
    });
    Route::get('/ubah-kata-sandi-bendum', [ProfilController::class, 'passwordbendum'])->name('ubah-sandi-bendum');
    Route::put('/bendum/password', [UserController::class, 'updatePassword'])->name('bendum-update-sandi');
    });

Route::middleware(['auth:anggota', 'ceklevel:Anggota'])->group(function () {
    Route::get('/beranda-anggota', [HomeController::class, 'anggota'])->name('beranda-anggota');
    Route::resource('sertifikat-anggota', AnggotaSertifikatController::class);
    Route::resource('dokumen-kegiatan-anggota', AnggotaDokumenKegiatanController::class);
    Route::resource('iuran-anggota', AnggotaIuranController::class);
    Route::resource('iurandetail-anggota', AnggotaIuranDetailController::class);
    Route::resource('pemasukan-anggota', AnggotaPemasukanController::class);
    Route::resource('kas-keluar-anggota', AnggotaKasKeluarController::class);
    Route::resource('laporan-kas-anggota', AnggotaLaporanKasController::class);
    Route::get(  '/cetak-laporan-kas/{tanggal_awal}/{tanggal_akhir}',  [AnggotaLaporanKasController::class, 'cetak'])->name('laporan-kas-anggota.cetak');
    Route::resource('member-anggota', AnggotaMemberController::class);
    Route::get('/profil-anggota', [ProfilController::class, 'anggota'])->name('profil-anggota');
    Route::get('/edit-profil-anggota', [ProfilController::class, 'editanggota'])->name('edit-profil-anggota');
    Route::prefix('anggota')->group(function () {
        Route::resource('anggota', AnggotaController::class)->names('anggotaprofil');
    });
    Route::get('/ubah-kata-sandi-anggota', [ProfilController::class, 'passwordanggota'])->name('ubah-sandi-anggota');
    Route::put('/anggota/password', [AnggotaController::class, 'updatePassword'])->name('anggota-update-sandi');
    });