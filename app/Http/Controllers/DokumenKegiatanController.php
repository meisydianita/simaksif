<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Dokumenkegiatan;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_kegiatan', 'like', '%' . $request->search . '%')
                    ->orwhere('deskripsi_kegiatan', 'like', '%' . $request->search . '%');
            });
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }


        $alldokumenkegiatan = $query->paginate(10)->appends($request->query());
        return view('sekum.dokumenkegiatan.dokumen-kegiatan', compact('alldokumenkegiatan', 'tahun'));
    }

    public function create()
    {
        $penanggungjawab = Member::where('status', 'aktif')->get();
        return view('sekum.dokumenkegiatan.add-dokumenkegiatan', compact('penanggungjawab'));
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kegiatan' => [
                'required',
                'string',
                'max:100',
                Rule::unique('dokumen_kegiatans')
                    ->where(fn($q) => $q->where('tahun', $request->tahun))
            ],
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'member_id' => 'required',
            'tahun' => 'required|digits:4',
            'deskripsi_kegiatan' => 'nullable|string|max:255',
            'proposal' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'laporan_pertanggungjawaban' => 'required|file|mimes:pdf,doc,docx|max:10240'
        ], [
            'nama_kegiatan.unique' => 'Nama kegiatan pada tahun tersebut sudah terdaftar.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'member_id.required' => 'Penanggungjawab wajib dipilih.',
            'member_id.exists' => 'Penanggungjawab tidak valid.',
            'tahun.max' => 'Format tahun salah.',
            'deskripsi_kegiatan.max' => 'Deskripsi kegiatan maksimal 255 karakter.',
            'proposal.max' => 'Ukuran proposal maksimal 10MB.',
            'proposal.mimes' => 'Proposal harus memiliki format pdf, doc, dan docx.',
            'laporan_pertanggungjawaban.max' => 'Ukuran LPJ maksimal 10MB.',
            'laporan_pertanggungjawaban.mimes' => 'Laporan Pertanggungjawaban harus memiliki format pdf, doc, dan docx.'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        try {
            $validatedData = $validator->validated();

            // simpan proposal
            $proposal = $request->file('proposal');
            $proposalname = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $proposal->getClientOriginalName();
            $proposal->storeAs('DokumenKegiatan/Proposal', $proposalname, 'public');
            $validatedData['proposal'] = $proposalname;

            // simpan lpj
            $lpj = $request->file('laporan_pertanggungjawaban');
            $lpjname = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $lpj->getClientOriginalName();
            $lpj->storeAs('DokumenKegiatan/Lpj', $lpjname, 'public');
            $validatedData['laporan_pertanggungjawaban'] = $lpjname;


            Dokumenkegiatan::create($validatedData);

            return redirect()
                ->route('dokumen-kegiatan.index')
                ->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->route('dokumen-kegiatan.index')
                ->with('error', ['Gagal menyimpan data. Silakan coba lagi.']);
        }
    }

    public function show(DokumenKegiatan $dokumen_kegiatan)
    {
        return view('sekum.dokumenkegiatan.dokumen-kegiatan', compact('dokumen_kegiatan'));
    }

    public function edit(DokumenKegiatan $dokumen_kegiatan)
    {
        $penanggungjawab = Member::where('status', 'aktif')->get();
        return view('sekum.dokumenkegiatan.edit-dokumenkegiatan', compact('dokumen_kegiatan', 'penanggungjawab'));
    }

    public function update(Request $request, DokumenKegiatan $dokumen_kegiatan)
    {
        $validator = Validator::make($request->all(), [
            'nama_kegiatan' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'member_id' => 'required',
            'tahun' => 'required|digits:4',
            'deskripsi_kegiatan' => 'required|string',
            'proposal' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'laporan_pertanggungjawaban' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ], [
            'nama_kegiatan.unique' => 'Nama kegiatan pada tahun tersebut sudah terdaftar.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'member_id.required' => 'Penanggungjawab wajib dipilih.',
            'member_id.exists' => 'Penanggungjawab tidak valid.',
            'tahun.max' => 'Format tahun salah.',
            'deskripsi_kegiatan.max' => 'Deskripsi kegiatan maksimal 255 karakter.',
            'proposal.max' => 'Ukuran proposal maksimal 10MB.',
            'proposal.mimes' => 'Proposal harus memiliki format pdf, doc, dan docx.',
            'laporan_pertanggungjawaban.max' => 'Ukuran LPJ maksimal 10MB.',
            'laporan_pertanggungjawaban.mimes' => 'Laporan Pertanggungjawaban harus memiliki format pdf, doc, dan docx.'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        try {
            // data akan diproses di sini saat disubmit
            // validate data
            $validatedData = $validator->validated();
            $isChanged = false;

            $mainFields = ['nama_kegiatan', 'tanggal_mulai', 'tanggal_selesai', 'member_id', 'tahun', 'deskripsi_kegiatan'];
            foreach ($mainFields as $field) {
                if ($request->filled($field) && $dokumen_kegiatan->$field != $request->$field) {
                    $isChanged = true;
                    break;
                }
            }

            if ($request->hasFile('proposal')) {

                if ($dokumen_kegiatan->proposal) {
                    Storage::disk('public')->delete('DokumenKegiatan/Proposal' . $dokumen_kegiatan->proposal);
                }
                $proposal = $request->file('proposal');
                $proposalname = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $proposal->getClientOriginalName();
                $proposal->storeAs('DokumenKegiatan/Proposal', $proposalname, 'public');
                $validatedData['proposal'] = $proposalname;
                $isChanged = true;
            }


            if ($request->hasFile('laporan_pertanggungjawaban')) {


                if ($dokumen_kegiatan->laporan_pertanggungjawaban) {
                    Storage::disk('public')->delete('DokumenKegiatan/Lpj' . $dokumen_kegiatan->laporan_pertanggungjawaban);
                }

                $lpj = $request->file('laporan_pertanggungjawaban');
                $lpjname = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $lpj->getClientOriginalName();
                $lpj->storeAs('DokumenKegiatan/Lpj', $lpjname, 'public');
                $validatedData['laporan_pertanggungjawaban'] = $lpjname;
                $isChanged = true;
            }

            // update data
            $dokumen_kegiatan->update($validatedData);

            //redirect to index ketika berhasil disimpan
            if ($isChanged) {
                return redirect()->route('dokumen-kegiatan.index')->with('success', 'Data berhasil diperbarui');
            }
            return redirect()->route('dokumen-kegiatan.index')->with('info', 'Tidak ada perubahan data.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data. Silahkan coba lagi. ');
        }
    }

    public function destroy($id)
    {
        $hapusDokumenKegiatan = DokumenKegiatan::findOrFail($id);

        if ($hapusDokumenKegiatan->proposal && Storage::disk('public')->exists('DokumenKegiatan/Proposal/' . $hapusDokumenKegiatan->proposal)) {
            Storage::disk('public')->delete('DokumenKegiatan/Proposal/' . $hapusDokumenKegiatan->proposal);
        }

        if ($hapusDokumenKegiatan->laporan_pertanggungjawaban && Storage::disk('public')->exists('DokumenKegiatan/Lpj/' . $hapusDokumenKegiatan->laporan_pertanggungjawaban)) {
            Storage::disk('public')->delete('DokumenKegiatan/Lpj/' . $hapusDokumenKegiatan->laporan_pertanggungjawaban);
        }

        $hapusDokumenKegiatan->delete();
        return redirect()->route('dokumen-kegiatan.index');
    }
}
