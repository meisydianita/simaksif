<?php

namespace App\Http\Controllers;

use App\Models\AnggotaDokumenKegiatan;
use Illuminate\Http\Request;

class AnggotaDokumenKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = AnggotaDokumenKegiatan::query();

        $tahun = AnggotaDokumenKegiatan::select('tahun')
                      ->distinct()
                      ->orderBy('tahun', 'DESC')
                      ->pluck('tahun', 'tahun')
                      ->toArray();

        if ($request->filled('search')){
            $query->where(function($q) use ($request) {
            $q->where('nama_kegiatan', 'like', '%'.$request->search . '%')
                ->orwhere('deskripsi_kegiatan', 'like', '%'.$request->search . '%');
            });
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }


        $alldokumenkegiatan = $query->paginate(10)->appends($request->query());
        return view ('anggota.dokumen-kegiatan', compact('alldokumenkegiatan', 'tahun'));
    }
}
