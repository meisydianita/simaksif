<?php

namespace App\Http\Controllers;

use App\Models\AnggotaMember;
use Illuminate\Http\Request;

class AnggotaMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = AnggotaMember::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('npm', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('no_hp', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('alamat', 'like', '%' . $request->search . '%');
            });
        }

        $tahun_masuk = AnggotaMember::select('tahun_masuk')
            ->distinct()
            ->orderBy('tahun_masuk', 'DESC')
            ->pluck('tahun_masuk', 'tahun_masuk')
            ->toArray();


        $jabatan = [
            'ketua_umum' => ' Ketua Umum',
            'sekretaris_umum' => 'Sekretaris Umum',
            'bendahara_umum' => 'Bendahara Umum',
            'kepala_divisi' => 'Kepala Divisi',
            'sekretaris_divisi' => 'Sekretaris Divisi',
            'anggota' => 'Anggota'
        ];

        $status = [
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif'
        ];

        $divisi = [
            'Kaderisasi' => 'Kaderisasi',
            'Kesekretariatan' => 'Kesekretariatan',
            'Mebiskraf' => 'Media Bisnis dan Kreatif',
            'PSDM' => 'Peningkatan Sumber Daya Mahasiswa',
            'PM' => 'Pengabdian Masyarakat',
            'Kerohanian' => 'Kerohanian'
        ];

        // filter tahun masuk
        if ($request->filled('tahun_masuk')) {
            $query->where('tahun_masuk', $request->tahun_masuk);
        }
        // filter divisi
        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }
        // filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        $allmember = $query->paginate(5)->appends(request()->query());
        return view('anggota.anggota', compact('allmember', 'jabatan', 'status', 'tahun_masuk', 'divisi'));
    }
}
