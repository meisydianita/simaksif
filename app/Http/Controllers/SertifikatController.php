<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Exception;
use GuzzleHttp\Psr7\Query;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'nomor_sertifikat' => 'required|unique:sertifikats,nomor_sertifikat',
            'nama_penerima' => 'required|string|max:100',
            'peran_penerima' => 'required',
            'nama_kegiatan' => 'required|string|max:100',
            'tanggal_sertifikat' => 'required|date',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ], [
            'nomor_sertifikat.unique' => 'Nomor sertifikat harus bersifat unik.',
            'nama_penerima.max' => 'Nama penerima maksimal 100 karakter.',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal 100 karakter.',
            'file_surat.max' => 'Ukuran surat maksimal 10MB.',
            'file.mimes' => 'File surat harus memiliki format pdf, doc, docx, jpg, jpeg, dan png.'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        try {
            // validate data
            $validatedData = $validator->validated();

            $file = $request->file('file');
            $filename = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $file->getClientOriginalName();
            $file->storeAs('Sertifikat', $filename, 'public');
            $validatedData['file'] = $filename;

            //simpan data
            Sertifikat::create($validatedData);

            //redirect to index ketika berhasil disimpan
            return redirect()
                ->route('sertifikat.index')
                ->with('success', 'Data berhasil ditambah.');
        } catch (Exception $e) {
            return redirect()
                ->route('sertifikat.index')
                ->with('error', ['Gagal menyimpan data. Silakan coba lagi.']);
        }
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
        $validator = Validator::make($request->all(), [
            'nomor_sertifikat' => 'required|unique:sertifikats,nomor_sertifikat,' . $sertifikat->id,
            'nama_penerima' => 'required|string|max:100',
            'peran_penerima' => 'required',
            'nama_kegiatan' => 'required|string|max:100',
            'tanggal_sertifikat' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'

        ], [
            'nomor_sertifikat.unique' => 'Nomor sertifikat harus bersifat unik.',
            'nama_penerima.max' => 'Nama penerima maksimal 100 karakter.',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal 100 karakter.',
            'file_surat.max' => 'Ukuran surat maksimal 10MB.',
            'file.mimes' => 'File surat harus memiliki format pdf, doc, docx, jpg, jpeg, dan png.'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        try {
            //function yang memproses saat update disubmit
            // validate data
            $validatedData = $validator->validate();
            $isChanged = false;

            $mainFields = ['nomor_sertifikat', 'nama_penerima', 'peran_penerima', 'nama_kegiatan', 'tanggal_sertifikat'];
            foreach ($mainFields as $field) {
                if ($request->filled($field) && $sertifikat->$field != $request->$field) {
                    $isChanged = true;
                    break;
                }
            }

            if ($request->hasFile('file')) {
                if ($sertifikat->file) {
                    Storage::disk('public')->delete('Sertifikat/' . $sertifikat->file);
                }
                $file = $request->file('file');
                $filename = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $file->getClientOriginalName();
                $file->storeAs('Sertifikat', $filename, 'public');
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
            return redirect()->route('sertifikat.index')
            ->with('error', 'Gagal memperbarui data. Silahkan coba lagi. ');
        }
    }

    public function destroy($id)
    {
        $hapusSertifikat = Sertifikat::findOrFail($id);
        if ($hapusSertifikat->file && Storage::disk('public')->exists('Sertifikat/' . $hapusSertifikat->file)) {
            Storage::disk('public')->delete('Sertifikat/' . $hapusSertifikat->file);
        }
        $hapusSertifikat->delete();
        return redirect()->route('sertifikat.index');
    }
}
