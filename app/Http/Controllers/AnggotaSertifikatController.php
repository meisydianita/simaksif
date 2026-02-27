<?php

namespace App\Http\Controllers;

use App\Models\AnggotaSertifikat;
use App\Models\Member;
use Illuminate\Http\Request;

class AnggotaSertifikatController extends Controller
{
    public function index(Request $request)
    {
        $peran_penerima = [
            'Pemateri' => 'Pemateri',
            'Peserta' => 'Peserta',
            'Panitia' => 'Panitia',
            'Pengurus' => 'Pengurus',
            'BPO' => 'Badan Pengurus Organisasi'
        ];

        $anggotaLogin = auth('anggota')->user();
        $member = Member::where('npm', $anggotaLogin->npm)->first();

        if (!$member) {
            $allsertifikat = collect();
            return view('anggota.sertifikat', compact('allsertifikat', 'peran_penerima'));
        }
        $query = AnggotaSertifikat::where('member_id', $member->id);


        if ($request->filled('search')) {
            $searchTerm = '%' . trim($request->search) . '%';

            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('nomor_sertifikat LIKE ?', [$searchTerm])
                    ->orWhereRaw('nama_penerima LIKE ?', [$searchTerm])
                    ->orWhereRaw('nama_kegiatan LIKE ?', [$searchTerm]);
            });
        }

        // Filter Peran Penerima
        if ($request->filled('peran_penerima')) {
            $query->where(function ($q) use ($request) {
                $q->where('peran_penerima', $request->peran_penerima);
            });
        }

        $allsertifikat = $query->latest()->paginate(10)->appends($request->query());
        return view('anggota.sertifikat', compact('allsertifikat', 'peran_penerima'));
    }
}
