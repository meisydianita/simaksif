<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\KasKeluar;
use App\Models\Pemasukan;
use Illuminate\Http\Request;

class LaporanKasController extends Controller
{
    public function index()
    {
        return view('bendum.laporankas.laporan-kas');
    }

    public function create() {}

    public function store(Request $request){}

    public function edit(string $id){}

    public function update(Request $request, string $id){}

    public function destroy(string $id){}

    public function cetak(Request $request)
    {

        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $kasIuran = Iuran::whereBetween('tanggal_bayar', [$tanggal_awal, $tanggal_akhir])
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal_bayar,
                    'nama' => 'Iuran ' . ($item->member->nama_lengkap . ' Bulan ' . ($item->bulan) . ' Tahun ' . ($item->tahun) ?? '-'),
                    'masuk' => $item->jumlah,
                    'keluar' => 0,
                ];
            });

        $kasPemasukan = Pemasukan::whereBetween('tanggal_pemasukan', [$tanggal_awal, $tanggal_akhir])
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal_pemasukan,
                    'nama' => $item->nama_pemasukan . ' Asal ' . $item->sumber_pemasukan,
                    'masuk' => $item->jumlah,
                    'keluar' => 0,
                ];
            });

        $kasKeluar = KasKeluar::whereBetween('tanggal_pengeluaran', [$tanggal_awal, $tanggal_akhir])
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal_pengeluaran,
                    'nama' => $item->nama_pengeluaran . ' ' . $item->penerima . ' ' .
                        \Carbon\Carbon::parse($item->tanggal_pengeluaran)->format('Y'),
                    'masuk' => 0,
                    'keluar' => $item->jumlah,
                ];
            });

        $laporanKas = $kasIuran
            ->merge($kasPemasukan)
            ->merge($kasKeluar)
            ->sortBy('tanggal')
            ->values();

        $totalMasuk = $laporanKas->sum('masuk');
        $totalKeluar = $laporanKas->sum('keluar');
        $sisaSaldo = $totalMasuk - $totalKeluar;

        return view(
            'bendum.laporankas.halaman-cetak',
            compact(
                'laporanKas',
                'totalKeluar',
                'totalMasuk',
                'sisaSaldo',
                'tanggal_awal',
                'tanggal_akhir'
            )
        );
    }
}
