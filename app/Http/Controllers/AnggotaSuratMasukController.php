<?php

namespace App\Http\Controllers;

use App\Models\AnggotaSuratMasuk;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;

class AnggotaSuratMasukController extends Controller
{
    public function index(Request $request, AnggotaSuratMasuk $anggotasuratmasuk, Query $query)
    {    
        $query = AnggotaSuratMasuk::query();

        if ($request->filled('search')) {
        $searchTerm = $request->search; 
        $query->where(function($q) use ($searchTerm) { 
            $q->where('nomor_surat', 'like', '%' . $searchTerm . '%')
              ->orWhere('asal_surat', 'like', '%' . $searchTerm . '%')
              ->orWhere('perihal', 'like', '%' . $searchTerm . '%');
        });
        }
       
        $allsuratmasuk = $query->paginate(10)->appends($request->query());
        return view ('anggota.surat-masuk', compact('allsuratmasuk'));
    }
}
