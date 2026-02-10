<?php

namespace App\Http\Controllers;

use App\Models\Suratmasuk;
use Exception;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|unique:surat_masuks,nomor_surat',
            'tanggal_surat' => 'required|date',
            'asal_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'required|file|mimes:pdf,doc,docx|max:10240'
        ], [
            'nomor_surat.unique' => 'Nomor surat harus bersifat unik.',
            'asal_surat.max' => 'Asal surat maksimal 255 karakter.',
            'perihal.max' => 'Perihal maksimal 255 karakter.',
            'file_surat.max' => 'Ukuran surat maksimal 10MB.',
            'file_surat.mimes' => 'File surat harus memiliki format pdf, doc, dan docx.'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        try {
            $validatedData = $validator->validated();

            $file = $request->file('file_surat');
            $filename = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $file->getClientOriginalName();
            $file->storeAs('SuratMasuk', $filename, 'public');
            $validatedData['file_surat'] = $filename;

            //simpan data
            Suratmasuk::create($validatedData);

            // redirect ke index ketika berhasil disimpan
            return redirect()->route('surat-masuk.index')
                ->with('success', 'Data berhasil ditambah.');
        } catch (Exception $e) {
            return redirect()
                ->with('error', ['Gagal menyimpan data. Silakan coba lagi.']);
        }
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
        $validator = Validator::make($request->all(), [
            'nomor_surat'   => 'required|unique:surat_masuks,nomor_surat,' . $surat_masuk->id,
            'tanggal_surat' => 'required|date',
            'asal_surat'    => 'required|string|max:255',
            'perihal'       => 'required|string|max:255',
            'file_surat'    => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ], [
            'nomor_surat.unique' => 'Nomor surat harus bersifat unik.',
            'asal_surat.max' => 'Asal surat maksimal 255 karakter.',
            'perihal.max' => 'Perihal maksimal 255 karakter.',
            'file_surat.max' => 'Ukuran surat maksimal 10MB.',
            'file_surat.mimes' => 'File surat harus memiliki format pdf, doc, dan docx.'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }
        
        try {
            $validatedData = $validator->validated();

            $isChanged = false;
            $mainFields = ['nomor_surat', 'tanggal_surat', 'asal_surat', 'perihal'];
            foreach ($mainFields as $field) {
                if ($request->filled($field) && $surat_masuk->$field != $request->$field) {
                    $isChanged = true;
                    break;
                }
            }
            if ($request->hasFile('file_surat')) {
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
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui data. Silahkan coba lagi. ');
        }
    }

    public function destroy($id)
    {
        $hapusSuratMasuk = SuratMasuk::findOrFail($id);
        if ($hapusSuratMasuk->file_surat && Storage::disk('public')->exists('SuratMasuk/' . $hapusSuratMasuk->file_surat)) {
            Storage::disk('public')->delete('SuratMasuk/' . $hapusSuratMasuk->file_surat);
        }

        $hapusSuratMasuk->delete();
        // redirect ke indext kategori
        return redirect()->route('surat-masuk.index');
    }

    public function download(Request $request, SuratMasuk $surat_masuk)
    {
        return response()->download(public_path('assets/' . $surat_masuk));
    }
}
