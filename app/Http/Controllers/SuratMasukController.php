<?php

namespace App\Http\Controllers;

use App\Models\Suratmasuk;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{

    public function index(Request $request, Suratmasuk $surat_masuk, Query $query)
    {    
        $query = Suratmasuk::query();

        if ($request->filled('search')) {
        $searchTerm = $request->search; 
        $query->where(function($q) use ($searchTerm) { 
            $q->where('nomor_surat', 'like', '%' . $searchTerm . '%')
              ->orWhere('asal_surat', 'like', '%' . $searchTerm . '%')
              ->orWhere('perihal', 'like', '%' . $searchTerm . '%');
        });
        }
       
        $allsuratmasuk = $query->paginate(10)->appends($request->query());
        return view ('sekum.suratmasuk.surat-masuk', compact('allsuratmasuk'));
    }

    public function create()
    {
        return view ('sekum.suratmasuk.add-suratmasuk');
    }

    public function store(Request $request)
    {
        //data akan diproses di sini ketika disubmit

        //buat validasi
        $validatedData = $request->validate([
            'nomor_surat'=>'required|unique:surat_masuks,nomor_surat',
            'tanggal_surat' => 'required|date',
            'asal_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'required|file|mimes:pdf,doc,docx|max:10240'
        ]);

         // simpan file ke storage
        $file = $request->file('file_surat');
        $filename = date('Y-m-d').'_'.$file->getClientOriginalName();
        $file->storeAs('SuratMasuk', $filename, 'public');

        // simpan nama file ke database
        $validatedData['file_surat'] = $filename;

        //simpan data
        Suratmasuk::create($validatedData);

        // redirect ke index ketika berhasil disimpan
        return redirect()->route('surat-masuk.index');
    }

    public function show(SuratMasuk $surat_masuk)
    {
        // menampilkan detail data
        return view ('sekum.suratmasuk.surat-masuk', compact ('surat_masuk'));
    }

    public function edit(SuratMasuk $surat_masuk)
    {
        return view ('sekum.suratmasuk.edit-suratmasuk', compact('surat_masuk'));
    }

    public function update(Request $request, SuratMasuk $surat_masuk)
    {
        //function yang akan memproses saat update disubmit
        //buat validasi
        $validatedData = $request->validate([            
            'nomor_surat'=>'required|unique:surat_masuks,nomor_surat,'. $surat_masuk->id,
            'tanggal_surat' => 'required|date',
            'asal_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);


         // CEK: apakah user upload file baru?
         if ($request->hasFile('file_surat')) {

            // hapus file lama (kalau ada)
            if ($surat_masuk->file_surat) {
                Storage::disk('public')->delete('SuratMasuk/'.$surat_masuk->file_surat);
            }

                // simpan file baru
                $file = $request->file('file_surat');
                $filename = date('Y-m-d').'_'.$file->getClientOriginalName();
                $file->storeAs('SuratMasuk', $filename, 'public');

                // update nama file di data
                $validatedData['file_surat'] = $filename;
        }

        //update data
        $surat_masuk->update($validatedData);

        // redirect ke index ketika berhasil diupdate
        return redirect()->route('surat-masuk.index');
    }

    public function destroy(SuratMasuk $surat_masuk)
    {
        $surat_masuk->delete();
        // redirect ke indext kategori
        return redirect()->route('surat-masuk.index');
    }

    public function download (Request $request, SuratMasuk $surat_masuk){
        return response()->download(public_path('assets/'.$surat_masuk));
    }

}
