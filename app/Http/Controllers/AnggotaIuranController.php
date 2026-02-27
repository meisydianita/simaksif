<?php

namespace App\Http\Controllers;

use App\Models\AnggotaIuran;
use App\Models\Member;
use Illuminate\Http\Request;

class AnggotaIuranController extends Controller
{
    public function index(Request $request)
    {
        $status = [
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif'
        ];

        $bulan = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
        $anggotaLogin = auth('anggota')->user();


        $memberLogin = Member::where('npm', $anggotaLogin->npm)->first();
        
        if (!$memberLogin) {
            return view('anggota.iuran', [
                'membersAll' => collect(),
                'memberLogin' => null,
                'iurans' => collect(),
                'tahun' => now()->year,
                'belumLunas' => 0,
                'totalIuran' => 0,
                'status' => $status
            ]);
        }

        $membersQuery = Member::query();

        if (!$request->filled('status')) {

            $membersQuery->where('id', $memberLogin->id);
        } else {
            $membersQuery
                ->where('status', $request->status)
                ->where('id', '!=', $memberLogin->id);
        }

        if ($request->filled('search')) {
            $membersQuery->where(function ($q) use ($request) {
                $q->where('npm', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('no_hp', 'like', '%' . $request->search . '%');
            });
        }


        if ($request->filled('status')) {
            $membersQuery->where('status', $request->status);
        }

        $tahun = now()->year;


        $membersAll = $membersQuery->get();

        $iurans = AnggotaIuran::with('member')
            ->where('tahun', $tahun)
            ->orderBy('member_id')
            ->orderBy('bulan')
            ->get();

        $totalIuran = AnggotaIuran::count();
        $belumLunas = AnggotaIuran::where('status', 'belum_lunas')->count();

        return view('anggota.iuran', compact('iurans', 'tahun', 'tahun', 'belumLunas', 'totalIuran', 'membersAll', 'status', 'memberLogin'));
    }
}
