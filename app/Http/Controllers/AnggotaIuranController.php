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

        $membersQuery = Member::query();

        if ($request->filled('search')) {
            $membersQuery->where(function ($q) use ($request) {
                $q->where('npm', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('no_hp', 'like', '%' . $request->search . '%');
            });
        }


        if ($request->filled('status') || $request->get('status') === null) {
            $membersQuery->where('status', $request->get('status', 'aktif'));
        }


        $membersAll = $membersQuery->get();
        // ambil semua member aktif
        $members = Member::where('status', 'aktif')->get();
        $tahun = $request->get('tahun', now()->year);

        foreach ($members as $member) {

            $memberAda = AnggotaIuran::where('member_id', $member->id)
                ->where('tahun', $tahun)
                ->exists();

            if (!$memberAda) {
                for ($bulan = 1; $bulan <= 12; $bulan++) {
                    AnggotaIuran::create([
                        'member_id' => $member->id,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'jumlah' => ($bulan == 1) ? 10000 : 5000,
                        'status' => 'belum_lunas'
                    ]);
                }
            }
        }
        $iurans = AnggotaIuran::with('member')
            ->where('tahun', $tahun)
            ->orderBy('member_id')
            ->orderBy('bulan')
            ->get();

        $totalIuran = AnggotaIuran::count();
        $belumLunas = AnggotaIuran::where('status', 'belum_lunas')->count();

        return view('anggota.iuran', compact('iurans', 'tahun', 'members', 'tahun', 'belumLunas', 'totalIuran', 'membersAll', 'status'));
    }
}
