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

        if ($request->filled('search')){
            $query->where(function ($q) use ($request){
            $q->where('nomor_sertifikat', 'like', '%'.$request->search . '%')
                ->orwhere('nama_penerima', 'like', '%'.$request->search . '%')
                ->orwhere('nama_kegiatan', 'like', '%'.$request->search . '%');
            }
        );
            
        }
         // Filter Jenis Surat
        if ($request->filled('peran_penerima')) {
            $query->where(function ($q) use ($request){
                $q->where('peran_penerima', $request->peran_penerima);
            }
        );
            
        }

        $allsertifikat = $query->paginate(10)->appends($request->query());
        return view ('anggota.sertifikat', compact('allsertifikat', 'peran_penerima'));
    }
}
