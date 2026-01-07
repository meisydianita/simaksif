<?php

namespace App\Http\Controllers;

use App\Models\Dokumenkegiatan;
use App\Models\Member;
use GuzzleHttp\Psr7\Query;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DokumenKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokumenkegiatan::query();

        $tahun = Dokumenkegiatan::select('tahun')
                      ->distinct()
                      ->orderBy('tahun', 'DESC')
                      ->pluck('tahun', 'tahun')
                      ->toArray();

        if ($request->filled('search')){
            $query->where(function($q) use ($request) {
            $q->where('nama_kegiatan', 'like', '%'.$request->search . '%')
                ->orwhere('deskripsi_kegiatan', 'like', '%'.$request->search . '%');
            });
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }


        $alldokumenkegiatan = $query->paginate(10)->appends($request->query());
        return view ('sekum.dokumenkegiatan.dokumen-kegiatan', compact('alldokumenkegiatan', 'tahun'));
    }

    public function create()
    {
        $penanggungjawab = Member::all();
        return view ('sekum.dokumenkegiatan.add-dokumenkegiatan', compact('penanggungjawab'));
    }

    public function store(Request $request)
    {
        //data akan diproses di sini ketika disubmit

        // validate data
        $validatedData=$request->validate([
            'nama_kegiatan'=>'required|string|max:100',
            'tanggal_mulai'=>'required|date',
            'tanggal_selesai'=>'required|date',
            'member_id'=>'required',
            'tahun'=>'required|digits:4',
            'deskripsi_kegiatan'=>'required|string',
            'proposal'=>'required|file|mimes:pdf,doc,docx|max:10240',
            'laporan_pertanggungjawaban' => 'required|file|mimes:pdf,doc,docx|max:10240'
        ]);

        //simpan proposal ke dalam storage
        $proposal = $request->file('proposal');
        $proposalname = date('Y-m-d').'_'.$proposal->getClientOriginalName();
        $proposal->storeAs('DokumenKegiatan/Proposal', $proposalname, 'public');
        
        //simpan lpj ke dalam storage
        $lpj = $request->file('laporan_pertanggungjawaban');
        $lpjname = date('Y-m-d').'_'.$lpj->getClientOriginalName();
        $lpj->storeAs('DokumenKegiatan/Lpj', $lpjname, 'public');

        //simpan nama proposal ke database
        $validatedData['proposal'] = $proposalname;

        //simpan nama lpj ke database
        $validatedData['laporan_pertanggungjawaban'] = $lpjname;

        //simpan data
        Dokumenkegiatan::create($validatedData);

        //redirect to index ketika berhasil disimpan
        return redirect()->route('dokumenkegiatan.index');
    }
    public function show(DokumenKegiatan $dokumenkegiatan)
    {
        return view ('sekum.dokumenkegiatan.dokumen-kegiatan', compact ('dokumenkegiatan'));
    }

    public function edit(DokumenKegiatan $dokumenkegiatan)
    {
        $penanggungjawab = Member::all();
        return view ('sekum.dokumenkegiatan.edit-dokumenkegiatan', compact('dokumenkegiatan', 'penanggungjawab'));
    }

    public function update(Request $request, DokumenKegiatan $dokumenkegiatan)
    {
        // data akan diproses di sini saat disubmit

        // validate data
        $validatedData=$request->validate([
            'nama_kegiatan'=>'required|string|max:100',
            'tanggal_mulai'=>'required|date',
            'tanggal_selesai'=>'required|date',
            'member_id'=>'required',
            'tahun'=>'required|digits:4',
            'deskripsi_kegiatan'=>'required|string',
            'proposal'=>'nullable|file|mimes:pdf,doc,docx|max:10240',
            'laporan_pertanggungjawaban' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);

        // cek apakah user upload file proposal baru
        if($request->hasFile('proposal')){
           
           // hapus file ketika sudah ada
           if($dokumenkegiatan->proposal){
            Storage::disk('public')->delete('DokumenKegiatan/Proposal'.$dokumenkegiatan->proposal);
           }
           // simpan ke file baru
           $proposal = $request->file('proposal');
           $proposalname = date('Y-m-d').'_'.$proposal->getClientOriginalName();
           $proposal->storeAs('DokumenKegiatan/Proposal', $proposalname, 'public');

           // update nama file di database
           $validatedData['proposal']=$proposalname;
        }

        // cek apakah user upload file lpj baru
        if($request->hasFile('laporan_pertanggungjawaban')){
           
           // hapus file ketika sudah ada
           if($dokumenkegiatan->laporan_pertanggungjawaban){
            Storage::disk('public')->delete('DokumenKegiatan/Lpj'.$dokumenkegiatan->laporan_pertanggungjawaban);
           }
           // simpan ke file baru
          $lpj = $request->file('laporan_pertanggungjawaban');
          $lpjname = date('Y-m-d').'_'.$lpj->getClientOriginalName();
          $lpj->storeAs('DokumenKegiatan/Lpj', $lpjname, 'public');

           // update nama file di database
           $validatedData['laporan_pertanggungjawaban']=$lpjname;
        }

        // update data
        $dokumenkegiatan->update($validatedData);

        //redirect to index ketika berhasil disimpan
        return redirect()->route('dokumenkegiatan.index');
    }

    public function destroy(DokumenKegiatan $dokumenkegiatan)
    {
        $dokumenkegiatan->delete();
        return redirect()->route('dokumenkegiatan.index');
    }
}
