<?php

namespace App\Http\Controllers;

use App\Models\KasKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\HttpCache\Store;

class KasKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = KasKeluar::query();
        $kategori =[
            'proker_skala_kecil' => 'Kegiatan Berskala Kecil',
            'proker_skala_besar' => 'Kegiatan Berskala Besar',
            'dana_lain' => 'Pendanaan Lain-lain'
        ];

        // Search
        if($request->filled('search')){
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
            $q->where('nama_pengeluaran', 'like', '%'.$searchTerm.'%')
              ->orWhere('penerima', 'like', '%'.$searchTerm.'%')
              ->orWhere('keterangan', 'like', '%'.$searchTerm.'%');
        });
        }

        // Filter kategori
        if ($request->filled('kategori')){
            $query->where('kategori', $request->kategori);
        }

        $allkaskeluar = $query->paginate(10)->appends($request->query());
        return view ('bendum.kaskeluar.kas-keluar', compact('allkaskeluar', 'kategori'));
    }

    public function create()
    {
        return view('bendum.kaskeluar.add-kaskeluar');
    }

    public function store(Request $request)
    {
        // make validation
        $validatedData = $request->validate([
            'nomor_pengeluaran'=>'required|unique:kas_keluars,nomor_pengeluaran',
            'nama_pengeluaran' => 'required|string|max:255',
            'tanggal_pengeluaran' => 'required|date',
            'kategori' => 'required',
            'jumlah' => 'required|numeric|min:0|max:99999999999999.99',
            'penerima' => 'required|string|max:255',            
            'keterangan' => 'nullable|string|max:255',
            'bukti'=>'required|image|max:2048'
        ], [
            'jumlah.max' => 'Jumlah terlalu besar! Maksimal Rp 99.999.999.999.999,99',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
        ]);

        // simpan file ke storage
        $file = $request->file('bukti');
        $filename = date('Y-m-d').'_'.$file->getClientOriginalName();
        $file->storeAs('KasKeluar', $filename, 'public');

        // simpan nama file ke database
        $validatedData['bukti'] = $filename;

        //simpan data
        KasKeluar::create($validatedData);

        // redirect ke index ketika berhasil disimpan
        return redirect()->route('kaskeluar.index');
        
    }

    public function show(KasKeluar $kaskeluar)
    {
        return view ('bendum.kaskeluar.kas-keluar', compact('kaskeluar'));
    }

    public function edit(KasKeluar $kaskeluar)
    {
        return view ('bendum.kaskeluar.edit-kaskeluar', compact('kaskeluar'));
    }

    public function update(Request $request, KasKeluar $kaskeluar)
    {
        // make validation
        $validatedData = $request->validate([
            'nomor_pengeluaran'=>'nullable|unique:kas_keluars,nomor_pengeluaran,'. $kaskeluar->id,
            'nama_pengeluaran' => 'required|string|max:255',
            'tanggal_pengeluaran' => 'required|date',
            'kategori' => 'required',
            'jumlah' => 'required|numeric|min:0|max:99999999999999.99',
            'penerima' => 'required|string|max:255',            
            'keterangan' => 'nullable|string|max:255',
            'bukti'=>'nullable|image|max:2048'
        ], [
            'jumlah.max' => 'Jumlah terlalu besar! Maksimal Rp 99.999.999.999.999,99',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
        ]);

        // cek apakah user upload foto baru
        if($request->hasFile('bukti')){

            // hapus file ketika sudah ada
            if($kaskeluar->bukti){
                Storage::disk('public')->delete('KasKeluar/'.$kaskeluar->bukti);
            }

            // simpan ke file baru
            $foto = $request->file('bukti');
            $fotoname = date('Y-m-d').'_'.$foto->getClientOriginalName();
            $foto->storeAs('KasKeluar', $fotoname, 'public');

            // simpan nama ke dalam database
            $validatedData['bukti']=$fotoname;
        }

        // update data
        $kaskeluar->update($validatedData);

        // redirect to index ketika berhasil diupdate
        return redirect()->route('kaskeluar.index');
    }

    public function destroy(KasKeluar $kaskeluar)
    {
        $kaskeluar->delete();
        return redirect()->route('kaskeluar.index');
    }
}
