<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKasKeluar;
use Illuminate\Http\Request;

class AnggotaKasKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = AnggotaKasKeluar::query();
        $kategori = [
            'proker_skala_kecil' => 'Kegiatan Berskala Kecil',
            'proker_skala_besar' => 'Kegiatan Berskala Besar',
            'dana_lain' => 'Pendanaan Lain-lain'
        ];

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_pengeluaran', 'like', '%' . $searchTerm . '%')
                    ->orWhere('penerima', 'like', '%' . $searchTerm . '%')
                    ->orWhere('keterangan', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $allkaskeluar = $query->paginate(10)->appends($request->query());
        return view('anggota.kas-keluar', compact('allkaskeluar', 'kategori'));
    }
}
