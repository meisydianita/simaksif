<?php

namespace App\Http\Controllers;

use App\Models\AnggotaSertifikat;
use Illuminate\Http\Request;

class AnggotaSertifikatController extends Controller
{
    public function index(Request $request)
    {
        $peran_penerima = [
            'Pemateri' => 'Pemateri',
            'Peserta' => 'Peserta',
            'Panitia' => 'Panitia'

        ];

        $query = AnggotaSertifikat::query();

        if ($request->filled('search')) {
            // Escape special chars + trim
            $searchTerm = '%' . trim($request->search) . '%';
            
            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('nomor_sertifikat LIKE ?', [$searchTerm])
                ->orWhereRaw('nama_penerima LIKE ?', [$searchTerm])
                ->orWhereRaw('nama_kegiatan LIKE ?', [$searchTerm]);
            });
        }

            
        // Filter Peran Penerima
        if ($request->filled('peran_penerima')) {
            $query->where(function ($q) use ($request){
                $q->where('peran_penerima', $request->peran_penerima);
            });            
        }

        $allsertifikat = $query->latest()->paginate(10)->appends($request->query());
        return view ('anggota.sertifikat', compact('allsertifikat', 'peran_penerima'));
    }
}
