<?php

namespace App\Http\Controllers;

use App\Models\Suratkeluar;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    public function index(Request $request, Suratkeluar $surat_keluar, Query $query)
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
        $query = Suratkeluar::query();

        // search di field text
        if ($request->filled('search')){
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) { 
                    $q->where('nomor_surat', 'like', '%'.$searchTerm . '%')
                    ->orWhere('tujuan_surat', 'like', '%'.$searchTerm . '%')
                    ->orWhere('perihal', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter Jenis Surat
        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        $allsuratkeluar = $query->latest()->paginate(10)->appends($request->query());
        return view ('sekum.suratkeluar.surat-keluar', compact('allsuratkeluar', 'jenis_surat'));
    }
    public function create()
    {
        return view ('sekum.suratkeluar.add-suratkeluar');
    }

    public function store(Request $request)
    {
        //data akan diproses di sini ketika disubmit

        //validate data
        $validatedData=$request->validate([
            'jenis_surat'=>'required',
            'nomor_surat'=>'required|unique:surat_keluars,nomor_surat',
            'tanggal_surat' => 'required|date',
            'tujuan_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'required|file|mimes:pdf,doc,docx|max:10240'
        ]);

        //simpan file ke dalam storage
        $file =$request->file('file_surat');
        $filename = date('Y-m-d').'_'. $file->getClientOriginalName();
        $file->storeAs('SuratKeluar', $filename, 'public');

        // simpan nama file ke database
        $validatedData['file_surat'] = $filename;

        //simpan data
        Suratkeluar::create($validatedData);

        //redirect to index ketika berhasil disimpan
        return redirect()->route('surat-keluar.index');
    }

    public function show(SuratKeluar $surat_keluar)
    {
        // menampilkan detail data
        return view ('sekum.suratkeluar.surat-keluar', compact('surat_keluar'));
    }

    public function edit(SuratKeluar $surat_keluar)
    {
        return view ('sekum.suratkeluar.edit-suratkeluar', compact('surat_keluar'));
    }

    public function update(Request $request, SuratKeluar $surat_keluar)
    {
        //function yang memproses saat update disubmit
        //validate data
        $validatedData=$request->validate([
            'jenis_surat'=>'required',
            'nomor_surat'=>'required|unique:surat_masuks,nomor_surat,'. $surat_keluar->id,
            'tanggal_surat' => 'required|date',
            'tujuan_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);

        //cek apakah user upload file baru
        if ($request->hasFile('file_surat')){

            //hapus file ketika sudah ada
            if ($surat_keluar->file_surat){
                Storage::disk('public')->delete('SuratKeluar/'.$surat_keluar->file_surat);
            }
            
            //simpan ke file baru
            $file =$request->file('file_surat');
            $filename = date('Y-m-d').'_'. $file->getClientOriginalName();
            $file->storeAs('SuratKeluar', $filename, 'public');

            //update nama file di database
            $validatedData['file_surat']=$filename;
        }

        //update data
        $surat_keluar->update($validatedData);

        //redirect to index ketika berhasil disimpan
        return redirect()->route('surat-keluar.index');

    }

    public function destroy($id)
    {
        $hapusSuratKeluar = SuratKeluar::findOrFail($id);        
        
        // hapus file bukti kalau ada
        if ($hapusSuratKeluar->file_surat && Storage::disk('public')->exists('SuratKeluar/'.$hapusSuratKeluar->file_surat)) {
            Storage::disk('public')->delete('SuratKeluar/'.$hapusSuratKeluar->file_surat);
        }

        $hapusSuratKeluar->delete();
        return redirect()->route('surat-keluar.index');

    }
}
