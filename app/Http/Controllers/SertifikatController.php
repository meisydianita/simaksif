<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use GuzzleHttp\Psr7\Query;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    public function index(Request $request)
    {
        $peran_penerima = [
            'Pemateri' => 'Pemateri',
            'Peserta' => 'Peserta',
            'Panitia' => 'Panitia'

        ];

        $query = Sertifikat::query();

        if ($request->filled('search')) {
            // Escape special chars + trim
            $searchTerm = '%' . trim($request->search) . '%';

            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('nomor_sertifikat LIKE ?', [$searchTerm])
                    ->orWhereRaw('nama_penerima LIKE ?', [$searchTerm])
                    ->orWhereRaw('nama_kegiatan LIKE ?', [$searchTerm]);
            });
        }


        // Filter Peran Penerima
        if ($request->filled('peran_penerima')) {
            $query->where(function ($q) use ($request) {
                $q->where('peran_penerima', $request->peran_penerima);
            });
        }

        $allsertifikat = $query->latest()->paginate(10)->appends($request->query());
        return view('sekum.sertifikat.sertifikat', compact('allsertifikat', 'peran_penerima'));
    }
    public function create()
    {
        return view('sekum.sertifikat.add-sertifikat');
    }
    public function store(Request $request)
    {
        //data akan diproses di sini ketika disubmit

        // validate data
        $validatedData = $request->validate([
            'nomor_sertifikat' => 'required|unique:sertifikats,nomor_sertifikat',
            'nama_penerima' => 'required|string|max:100',
            'peran_penerima' => 'required',
            'nama_kegiatan' => 'required|string|max:100',
            'tanggal_sertifikat' => 'required|date',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        //simpan file ke dalam storage
        $file = $request->file('file');
        $filename = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $file->getClientOriginalName();
        $file->storeAs('Sertifikat', $filename, 'public');

        //simpan nama file ke database
        $validatedData['file'] = $filename;

        //simpan data
        Sertifikat::create($validatedData);

        //redirect to index ketika berhasil disimpan
        return redirect()->route('sertifikat.index');
    }
    public function show(Sertifikat $sertifikat)
    {
        return view('sekum.sertifikat.sertifikat', compact('sertifikat'));
    }

    public function edit(Sertifikat $sertifikat)
    {
        return view('sekum.sertifikat.edit-sertifikat', compact('sertifikat'));
    }

    public function update(Request $request, Sertifikat $sertifikat)
    {
        try {
            //function yang memproses saat update disubmit
            // validate data
            $validatedData = $request->validate([
                'nomor_sertifikat' => 'required|unique:sertifikats,nomor_sertifikat,' . $sertifikat->id,
                'nama_penerima' => 'required|string|max:100',
                'peran_penerima' => 'required',
                'nama_kegiatan' => 'required|string|max:100',
                'tanggal_sertifikat' => 'required|date',
                'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
            ]);
            $isChanged = false;

            $mainFields = ['nomor_sertifikat', 'nama_penerima', 'peran_penerima', 'nama_kegiatan', 'tanggal_sertifikat'];
            foreach ($mainFields as $field) {
                if ($request->filled($field) && $sertifikat->$field != $request->$field) {
                    $isChanged = true;
                    break;
                }
            }

            //cek apakah user upload file baru
            if ($request->hasFile('file')) {

                // hapus file ketika sudah ada
                if ($sertifikat->file) {
                    Storage::disk('public')->delete('Sertifikat/' . $sertifikat->file);
                }

                // simpan ke file baru
                $file = $request->file('file');
                $filename = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $file->getClientOriginalName();
                $file->storeAs('Sertifikat', $filename, 'public');

                // update nama file di database
                $validatedData['file'] = $filename;
                $isChanged = true;
            }

            // update data
            $sertifikat->update($validatedData);

            // redirect ke index ketika berhasil disimpan
            if ($isChanged) {
                return redirect()->route('sertifikat.index')->with('success', 'Data berhasil diperbarui.');
            }
            return redirect()->route(route: 'sertifikat.index')->with('info', 'Tidak ada perubahan data.');
        } catch (\Exception $e) {
            return redirect()->route('sertifikat.index')->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $hapusSertifikat = Sertifikat::findOrFail($id);

        // hapus file bukti kalau ada
        if ($hapusSertifikat->file && Storage::disk('public')->exists('Sertifikat/' . $hapusSertifikat->file)) {
            Storage::disk('public')->delete('Sertifikat/' . $hapusSertifikat->file);
        }

        // hapus data
        $hapusSertifikat->delete();
        return redirect()->route('sertifikat.index');
    }
}
