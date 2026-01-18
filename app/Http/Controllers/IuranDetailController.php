<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\IuranDetail;
use App\Models\Member;
use Illuminate\Http\Request;

class IuranDetailController extends Controller
{
    public function index(Request $request)
    {
    
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }
    public function show($memberId)
    {
     $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    $iurans = Iuran::where('member_id', $memberId)
        ->orderBy('tahun')
        ->orderBy('bulan')
        ->paginate(12)  
        ->appends(request()->query());  

    $member = Member::findOrFail($memberId);

    return view('bendum.iuran.iurandetail', compact(
        'bulan',
        'iurans',
        'member'
    ));
    }



    public function edit(Iuran $iuran)
    {
        
    }

    public function update(Request $request, IuranDetail $iuranDetail)
    {
        //
    }

    public function destroy(IuranDetail $iuranDetail)
    {
        //
    }
}
