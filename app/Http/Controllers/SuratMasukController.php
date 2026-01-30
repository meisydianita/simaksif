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
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nomor_surat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('asal_surat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('perihal', 'like', '%' . $searchTerm . '%');
            });
        }

        $allsuratmasuk = $query->paginate(10)->appends($request->query());
        return view('sekum.suratmasuk.surat-masuk', compact('allsuratmasuk'));
    }

    public function create()
    {
        return view('sekum.suratmasuk.add-suratmasuk');
    }

    public function store(Request $request)
    {
        //data akan diproses di sini ketika disubmit

        //buat validasi
        $validatedData = $request->validate([
            'nomor_surat' => 'required|unique:surat_masuks,nomor_surat',
            'tanggal_surat' => 'required|date',
            'asal_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'required|file|mimes:pdf,doc,docx|max:10240'
        ]);

        // simpan file ke storage
        $file = $request->file('file_surat');
        $filename = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $file->getClientOriginalName();
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
        return view('sekum.suratmasuk.surat-masuk', compact('surat_masuk'));
    }

    public function edit(SuratMasuk $surat_masuk)
    {
        return view('sekum.suratmasuk.edit-suratmasuk', compact('surat_masuk'));
    }

    public function update(Request $request, SuratMasuk $surat_masuk)
    {
        try {
            $validatedData = $request->validate([
                'nomor_surat'   => 'required|unique:surat_masuks,nomor_surat,' . $surat_masuk->id,
                'tanggal_surat' => 'required|date',
                'asal_surat'    => 'required|string|max:255',
                'perihal'       => 'required|string|max:255',
                'file_surat'    => 'nullable|file|mimes:pdf,doc,docx|max:10240'
            ]);

            $isChanged = false;

            // Cek perubahan field utama
            $mainFields = ['nomor_surat', 'tanggal_surat', 'asal_surat', 'perihal'];
            foreach ($mainFields as $field) {
                if ($request->filled($field) && $surat_masuk->$field != $request->$field) {
                    $isChanged = true;
                    break;
                }
            }

            // Upload file baru (kalau ada)
            if ($request->hasFile('file_surat')) {
                // hapus file lama
                if ($surat_masuk->file_surat) {
                    Storage::disk('public')->delete('SuratMasuk/' . $surat_masuk->file_surat);
                }

                $file = $request->file('file_surat');
                $filename = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $file->getClientOriginalName();
                $file->storeAs('SuratMasuk', $filename, 'public');

                $validatedData['file_surat'] = $filename;
                $isChanged = true;
            }

            if ($isChanged) {
                $surat_masuk->update($validatedData);
                return redirect()->route('surat-masuk.index')->with('success', 'Data berhasil diperbarui.');
            }

            return redirect()->route('surat-masuk.index')->with('info', 'Tidak ada perubahan data.');
        } catch (\Exception $e) {
            return redirect()->route('surat-masuk.index')->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $hapusSuratMasuk = SuratMasuk::findOrFail($id);

        // hapus file bukti kalau ada
        if ($hapusSuratMasuk->file_surat && Storage::disk('public')->exists('SuratMasuk/' . $hapusSuratMasuk->file_surat)) {
            Storage::disk('public')->delete('SuratMasuk/' . $hapusSuratMasuk->file_surat);
        }

        $hapusSuratMasuk->delete();
        // redirect ke indext kategori
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function download(Request $request, SuratMasuk $surat_masuk)
    {
        return response()->download(public_path('assets/' . $surat_masuk));
    }
}
