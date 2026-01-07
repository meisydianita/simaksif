<?php

namespace App\Http\Controllers;

use App\Models\Dokumenkegiatan;
use App\Models\Member;
use App\Models\Sertifikat;
use App\Models\Suratkeluar;
use App\Models\Suratmasuk;
// use Illuminate\Container\Attributes\DB;
use DB;
use Illuminate\Http\Request;

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
        'bulan'));
        
    }

    public function bendum (){
        return view ('bendum.home-bendum');
    }

    public function anggota (){
        return view ('anggota.home-anggota');
    }

}
