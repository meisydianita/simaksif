<?php

namespace App\Http\Controllers;

use App\Models\KasKeluar;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\HttpCache\Store;

class KasKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = KasKeluar::query();
        $kategori = [
            'proker_skala_kecil' => 'Kegiatan Berskala Kecil',
            'proker_skala_besar' => 'Kegiatan Berskala Besar',
            'dana_lain' => 'Pendanaan Lain-lain'
        ];

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_pengeluaran', 'like', '%' . $searchTerm . '%')
                    ->orWhere('penerima', 'like', '%' . $searchTerm . '%')
                    ->orWhere('keterangan', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $allkaskeluar = $query->paginate(10)->appends($request->query());
        return view('bendum.kaskeluar.kas-keluar', compact('allkaskeluar', 'kategori'));
    }

    public function create()
    {
        return view('bendum.kaskeluar.add-kaskeluar');
    }

    public function store(Request $request)
    {
        try {
            // make validation
            $validatedData = $request->validate([
                'nomor_pengeluaran' => 'required|unique:kas_keluars,nomor_pengeluaran',
                'nama_pengeluaran' => 'required|string|max:255',
                'tanggal_pengeluaran' => 'required|date',
                'kategori' => 'required',
                'jumlah' => 'required|numeric|min:0|max:99999999999999.99',
                'penerima' => 'required|string|max:255',
                'keterangan' => 'nullable|string|max:255',
                'bukti' => 'required|image|max:2048'
            ], [
                'jumlah.max' => 'Jumlah terlalu besar! Maksimal Rp 99.999.999.999.999,99',
                'jumlah.numeric' => 'Jumlah harus berupa angka',
            ]);

            // simpan file ke storage
            $file = $request->file('bukti');
            $filename = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $file->getClientOriginalName();
            $file->storeAs('KasKeluar', $filename, 'public');

            // simpan nama file ke database
            $validatedData['bukti'] = $filename;

            //simpan data
            KasKeluar::create($validatedData);

            // redirect ke index ketika berhasil disimpan
            return redirect()->route('kas-keluar.index')->with('success', 'Data berhasil ditambah.');
        } catch (Exception $e) {
            return redirect()->route('kas-keluar.index')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show(KasKeluar $kas_keluar)
    {
        return view('bendum.kaskeluar.kas-keluar', compact('kas_keluar'));
    }

    public function edit(KasKeluar $kas_keluar)
    {
        return view('bendum.kaskeluar.edit-kaskeluar', compact('kas_keluar'));
    }

    public function update(Request $request, KasKeluar $kas_keluar)
    {
        try {
            // make validation
            $validatedData = $request->validate([
                'nomor_pengeluaran' => 'nullable|unique:kas_keluars,nomor_pengeluaran,' . $kas_keluar->id,
                'nama_pengeluaran' => 'required|string|max:255',
                'tanggal_pengeluaran' => 'required|date',
                'kategori' => 'required',
                'jumlah' => 'required|numeric|min:0|max:99999999999999.99',
                'penerima' => 'required|string|max:255',
                'keterangan' => 'nullable|string|max:255',
                'bukti' => 'nullable|image|max:2048'
            ], [
                'jumlah.max' => 'Jumlah terlalu besar! Maksimal Rp 99.999.999.999.999,99',
                'jumlah.numeric' => 'Jumlah harus berupa angka',
            ]);
            $isChanged = false;

            $mainFields = ['nomor_pengeluaran', 'nama_pengeluaran', 'tanggal_pengeluaran', 'kategori', 'jumlah', 'penerima', 'keterangan'];
            foreach ($mainFields as $field) {
                if ($request->filled($field) && $kas_keluar->$field != $request->$field) {
                    $isChanged = true;
                    break;
                }
            }

            // cek apakah user upload foto baru
            if ($request->hasFile('bukti')) {

                // hapus file ketika sudah ada
                if ($kas_keluar->bukti) {
                    Storage::disk('public')->delete('KasKeluar/' . $kas_keluar->bukti);
                }

                // simpan ke file baru
                $foto = $request->file('bukti');
                $fotoname = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $foto->getClientOriginalName();
                $foto->storeAs('KasKeluar', $fotoname, 'public');

                // simpan nama ke dalam database
                $validatedData['bukti'] = $fotoname;
            }

            // update data
            $kas_keluar->update($validatedData);


            // redirect to index ketika berhasil diupdate
            if ($isChanged) {
                return redirect()->route('kas-keluar.index')->with('success', 'Data berhasil diperbarui.');
            }
            return redirect()->route('kas-keluar.index')->with('info', 'Tidak ada perubahan data.');
        } catch (\Exception $e) {
            return redirect()->route('kas-keluar.index')->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $hapusKasKeluar = KasKeluar::findOrFail($id);

        // hapus file bukti
        if ($hapusKasKeluar->bukti && Storage::disk('public')->exists('KasKeluar/' . $hapusKasKeluar->bukti)) {
            Storage::disk('public')->delete('KasKeluar/' . $hapusKasKeluar->bukti);
        }

        // hapus data
        $hapusKasKeluar->delete();
        return redirect()->route('kas-keluar.index');
    }
}
