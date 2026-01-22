<?php

namespace App\Http\Controllers;

use App\Models\AnggotaIuran;
use App\Models\Member;
use Illuminate\Http\Request;

class AnggotaIuranDetailController extends Controller
{
    public function show($memberId)
    {
     $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    $iurans = AnggotaIuran::where('member_id', $memberId)
        ->orderBy('tahun')
        ->orderBy('bulan')
        ->paginate(12)  
        ->appends(request()->query());  

    $member = Member::findOrFail($memberId);

    return view('anggota.iurandetail', compact(
        'bulan',
        'iurans',
        'member'
    ));
    }
}
