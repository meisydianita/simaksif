<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemasukan::query();
        $kategori =[
            'dana_universitas' => 'Dana Universitas',
            'donasi_umum' => 'Donasi Umum',
            'sumbangan_anggota' => 'Sumbangan Anggota',
            'usaha_kewirausahaan' => 'Usaha dan Kewirausahaan',
            'sponsor' => 'Sponsor',
            'sisa_dana_kegiatan' => 'Sisa Dana Kegiatan'
        ];

        // Search
        if($request->filled('search')){
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
            $q->where('nama_pemasukan', 'like', '%'.$searchTerm.'%')
              ->orWhere('sumber_pemasukan', 'like', '%'.$searchTerm.'%')
              ->orWhere('keterangan', 'like', '%'.$searchTerm.'%');
        });
        }

        // Filter kategori
        if ($request->filled('kategori')){
            $query->where('kategori', $request->kategori);
        }

        $allpemasukan = $query->paginate(10)->appends(request()->query());
        return view ('bendum.pemasukan.pemasukan', compact('allpemasukan', 'kategori'));
    }

    public function create()
    {
        return view ('bendum.pemasukan.add-pemasukan');
    }

    public function store(Request $request)
    {
        // make validation
        $validatedData = $request->validate([
            'nomor_pemasukan'=>'required|unique:pemasukans,nomor_pemasukan',
            'nama_pemasukan' => 'required|string|max:255',
            'tanggal_pemasukan' => 'required|date',
            'kategori' => 'required',
            'sumber_pemasukan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0|max:99999999999999.99',
            'keterangan' => 'nullable|string|max:255',
            'bukti'=>'nullable|image|max:2048'
        ], [
            'jumlah.max' => 'Jumlah terlalu besar! Maksimal Rp 99.999.999.999.999,99',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
        ]);
        

        // simpan file ke storage
        $file = $request->file('bukti');
        $filename = date('Y-m-d').'_'.$file->getClientOriginalName();
        $file->storeAs('Pemasukan', $filename, 'public');

        // simpan nama file ke database
        $validatedData['bukti'] = $filename;

        //simpan data
        Pemasukan::create($validatedData);

        // redirect ke index ketika berhasil disimpan
        return redirect()->route('pemasukan.index');
    }
    public function show(Pemasukan $pemasukan)
    {
        return view ('bendum.pemasukan.pemasukan', compact('pemasukan'));
    }
    public function edit(Pemasukan $pemasukan)
    {
        return view ('bendum.pemasukan.edit-pemasukan', compact('pemasukan'));
    }

    public function update(Request $request, Pemasukan $pemasukan)
    {
        // update validation
        $validatedData = $request->validate([
            'nomor_pemasukan'=>'nullable|unique:pemasukans,nomor_pemasukan,'. $pemasukan->id,
            'nama_pemasukan' => 'required|string|max:255',
            'tanggal_pemasukan' => 'required|date',
            'kategori' => 'required',
            'sumber_pemasukan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0|max:99999999999999.99',
            'keterangan' => 'nullable|string|max:255',
            'bukti'=>'nullable|image|max:2048'
        ], [
            'jumlah.max' => 'Jumlah terlalu besar! Maksimal Rp 99.999.999.999.999,99',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
        ]);

        // cek apakah user upload foto baru
        if($request->hasFile('bukti')){

            // hapus file ketika sudah ada
            if($pemasukan->bukti){
                Storage::disk('public')->delete('Pemasukan/'.$pemasukan->bukti);
            }

            // simpan ke file baru
            $foto = $request->file('bukti');
            $fotoname = date('Y-m-d').'_'.$foto->getClientOriginalName();
            $foto->storeAs('Pemasukan', $fotoname, 'public');

            // simpan nama ke dalam database
            $validatedData['bukti']=$fotoname;
        }

        // update data
        $pemasukan->update($validatedData);

        // redirect to index ketika berhasil diupdate
        return redirect()->route('pemasukan.index');
    }

    public function destroy(Pemasukan $pemasukan)
    {
        $pemasukan->delete();
        // redirect to index ketika berhasil dihapus
        return redirect()->route('pemasukan.index');
    }
}
