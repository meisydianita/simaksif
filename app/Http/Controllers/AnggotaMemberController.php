<?php

namespace App\Http\Controllers;

use App\Models\AnggotaMember;
use Illuminate\Http\Request;

class AnggotaMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = AnggotaMember::select(
            'id',
            'npm',
            'nama_lengkap',
            'tahun_masuk',
            'status',
            'foto'
        );

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('npm', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $request->search . '%');
            });
        }

        $tahun_masuk = AnggotaMember::select('tahun_masuk')
            ->distinct()
            ->orderByDesc('tahun_masuk')
            ->pluck('tahun_masuk');

        $status = [
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif'
        ];

        // filter tahun masuk
        if ($request->filled('tahun_masuk')) {
            $query->where('tahun_masuk', $request->tahun_masuk);
        }

        // filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        $allmember = $query->paginate(5)->appends(request()->query());
        return view('anggota.anggota', compact('allmember', 'status', 'tahun_masuk'));
    }
}
