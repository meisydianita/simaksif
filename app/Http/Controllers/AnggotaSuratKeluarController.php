<?php

namespace App\Http\Controllers;

use App\Models\AnggotaSuratKeluar;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;

class AnggotaSuratKeluarController extends Controller
{
    public function index(Request $request, AnggotaSuratKeluar $surat_keluar, Query $query)
    {
        $jenis_surat = [
            'sk_pengangkatan' => 'Surat Kerja Pengangkatan',
            'peminjaman_tempat_barang' => 'Peminjaman Barang/Tempat',
            'izin_kegiatan' => 'Izin Kegiatan',
            'undangan' => 'Undangan',
            'permohonan_dana' => 'Permohonan Dana',
            'aktif_organisasi' => 'Aktif Organisasi',
            'peringatan' => 'Peringatan'
        ];
        $query = AnggotaSuratKeluar::query();

        // search di field text
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nomor_surat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('tujuan_surat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('perihal', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter Jenis Surat
        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        $allsuratkeluar = $query->latest()->paginate(10)->appends($request->query());
        return view('anggota.surat-keluar', compact('allsuratkeluar', 'jenis_surat'));
    }
}
