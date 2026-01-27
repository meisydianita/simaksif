<?php

namespace App\Http\Controllers;

use App\Models\AnggotaPemasukan;
use Illuminate\Http\Request;

class AnggotaPemasukanController extends Controller
{
    public function index(Request $request)
    {
        $query = AnggotaPemasukan::query();
        $kategori = [
            'dana_universitas' => 'Dana Universitas',
            'donasi_umum' => 'Donasi Umum',
            'sumbangan_anggota' => 'Sumbangan Anggota',
            'usaha_kewirausahaan' => 'Usaha dan Kewirausahaan',
            'sponsor' => 'Sponsor',
            'sisa_dana_kegiatan' => 'Sisa Dana Kegiatan'
        ];

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_pemasukan', 'like', '%' . $searchTerm . '%')
                    ->orWhere('sumber_pemasukan', 'like', '%' . $searchTerm . '%')
                    ->orWhere('keterangan', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $allpemasukan = $query->paginate(10)->appends(request()->query());
        return view('anggota.pemasukan', compact('allpemasukan', 'kategori'));
    }
}
