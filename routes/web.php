<?php

use App\Http\Controllers\AnggotaDokumenKegiatanController;
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

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');
Route::post('/postlogout', [LoginController::class, 'postlogout'])->name('logout');

Route::middleware(['auth:user', 'ceklevel:Sekretaris Umum'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Route::get('/home', [HomeController::class, 'grafiksekum'])->name('home');
    Route::resource('suratmasuk', SuratMasukController::class);
    Route::post('/download(suratmasuk)', [SuratMasukController::class, 'download'])->name('downloadsuratmasuk');
    Route::resource('suratkeluar', SuratKeluarController::class);
    Route::resource('sertifikat', SertifikatController::class);
    Route::resource('dokumenkegiatan', DokumenKegiatanController::class);
    Route::resource('member', MemberController::class);
    });

Route::middleware(['auth:user', 'ceklevel:Bendahara Umum'])->group(function () {
    Route::get('/home-bendum', [HomeController::class, 'bendum'])->name('home-bendum');
    Route::resource('iuran', IuranController::class);
    Route::resource('iurandetail', IuranDetailController::class);
    Route::resource('pemasukan', PemasukanController::class);
    Route::resource('kaskeluar', KasKeluarController::class);
    Route::resource('laporankas', LaporanKasController::class);
    });

Route::middleware(['auth:anggota', 'ceklevel:Anggota'])->group(function () {
    Route::get('/home-anggota', [HomeController::class, 'anggota'])->name('home-anggota');
    Route::resource('anggotasuratmasuk', AnggotaSuratMasukController::class);
    Route::resource('anggotasuratkeluar', AnggotaSuratKeluarController::class);
    Route::resource('anggotasertifikat', AnggotaSertifikatController::class);
    Route::resource('anggotadokumenkegiatan', AnggotaDokumenKegiatanController::class);
    });