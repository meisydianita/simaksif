<?php

namespace App\Http\Controllers;

use App\Models\Dokumenkegiatan;
use App\Models\Iuran;
use App\Models\KasKeluar;
use App\Models\Member;
use App\Models\Pemasukan;
use App\Models\Sertifikat;
use App\Models\Suratkeluar;
use App\Models\Suratmasuk;
// use Illuminate\Container\Attributes\DB;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

class HomeController extends Controller
{
    public function index (){
        $totalsuratmasuk = Suratmasuk::count();
        $totalsuratkeluar = Suratkeluar::count();
        $totalsertifikat = Sertifikat::count();
        $totaldokumenkegiatan = Dokumenkegiatan::count();
        $totalmemberaktif = Member::where('status',  'aktif')->count();
        $totalmembernonaktif = Member::where('status',  'tidak_aktif')->count();

        $tahunSekarang = date('Y');
    
        $querySuratMasuk = Suratmasuk::whereYear('created_at', $tahunSekarang)
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
              
        $querySuratKeluar = Suratkeluar::whereYear('created_at', $tahunSekarang)
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        $queryDokumenKegiatan = Dokumenkegiatan::whereYear('created_at', $tahunSekarang)
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        $querySertifikat = Sertifikat::whereYear('created_at', $tahunSekarang)
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        // Fungsi untuk mapping data ke array 12 bulan
        function mapDataKeBulan($query) {
            $data = array_fill(0, 12, 0); 
            foreach ($query as $item) {
                $data[$item->bulan - 1] = $item->total; 
            }
            return $data;
        }
        
        $grafiktotalsuratmasuk = mapDataKeBulan($querySuratMasuk);
        $grafiktotalsuratkeluar = mapDataKeBulan($querySuratKeluar);
        $grafiktotaldokumenkegiatan = mapDataKeBulan($queryDokumenKegiatan);
        $grafiktotalsertifikat = mapDataKeBulan($querySertifikat);         
       
        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        
        return view ('sekum.home', compact('totalsuratmasuk', 
        'totalsuratkeluar', 'totalsertifikat', 'totaldokumenkegiatan', 
        'totalmemberaktif', 'totalmembernonaktif', 'grafiktotalsuratmasuk', 'grafiktotalsuratkeluar',  
        'grafiktotaldokumenkegiatan', 'grafiktotalsertifikat',
        'bulan', 'tahunSekarang'));
        
    }

    public function bendum() 
    {
    $tahunSekarang = now()->year;
    $tanggalMulaiTahun = now()->startOfYear();


    $kasMasukIuran = Iuran::where('status', 'lunas')
        ->whereYear('tanggal_bayar', $tahunSekarang)
        ->selectRaw('MONTH(tanggal_bayar) as bulan, SUM(jumlah) as total')
        ->groupBy(\Illuminate\Support\Facades\DB::raw('YEAR(tanggal_bayar), MONTH(tanggal_bayar)')) 
        ->orderBy('bulan')
        ->get();

    $kasMasukPemasukan = Pemasukan::whereYear('tanggal_pemasukan', $tahunSekarang)
        ->selectRaw('MONTH(tanggal_pemasukan) as bulan, SUM(jumlah) as total')
        ->groupBy(\Illuminate\Support\Facades\DB::raw('YEAR(tanggal_pemasukan), MONTH(tanggal_pemasukan)'))
        ->orderBy('bulan')
        ->get();

    $kasKeluar = KasKeluar::whereYear('tanggal_pengeluaran', $tahunSekarang)
        ->selectRaw('MONTH(tanggal_pengeluaran) as bulan, SUM(jumlah) as total')
        ->groupBy(\Illuminate\Support\Facades\DB::raw('YEAR(tanggal_pengeluaran), MONTH(tanggal_pengeluaran)'))
        ->orderBy('bulan')
        ->get();

    $grafikKasMasuk = array_fill(0, 12, 0);
    foreach ($kasMasukIuran as $item) {
        $grafikKasMasuk[$item->bulan - 1] = $item->total;
    }
    foreach ($kasMasukPemasukan as $item) {
        $grafikKasMasuk[$item->bulan - 1] += $item->total;
    }

    $grafikKasKeluar = array_fill(0, 12, 0);
    foreach ($kasKeluar as $item) {
        $grafikKasKeluar[$item->bulan - 1] = (int) $item->total;
    }

    $saldoAwal =
        (
            Iuran::where('status', 'lunas')
                ->whereDate('tanggal_bayar', '<', $tanggalMulaiTahun)
                ->sum('jumlah')
            +
            Pemasukan::whereDate('tanggal_pemasukan', '<', $tanggalMulaiTahun)
                ->sum('jumlah')
        )
        -
        KasKeluar::whereDate('tanggal_pengeluaran', '<', $tanggalMulaiTahun)
            ->sum('jumlah');

    
    $totaliuran = Iuran::where('status', 'lunas')
        ->whereYear('tanggal_bayar', $tahunSekarang)
        ->sum('jumlah');

    $totalpemasukan = Pemasukan::whereYear('tanggal_pemasukan', $tahunSekarang)
        ->sum('jumlah');

    $totalkasmasuk = $totaliuran + $totalpemasukan;

    
    $totalkaskeluar = KasKeluar::whereYear('tanggal_pengeluaran', $tahunSekarang)
        ->sum('jumlah');

    
    $sisasaldo = $saldoAwal + $totalkasmasuk - $totalkaskeluar;

    $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    return view('bendum.home-bendum', compact(
        'totalkasmasuk',
        'totalkaskeluar',
        'sisasaldo',
        'grafikKasMasuk',
        'grafikKasKeluar',
        'bulan',
        'tahunSekarang'
    ));
    }



    public function anggota (){
        return view ('anggota.home-anggota');
    }

}
