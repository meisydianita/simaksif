<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IuranController extends Controller
{
    public function index(Request $request)
    {
        $status = [
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif'
        ];

        $bulan = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $membersQuery = Member::query();

        if ($request->filled('search')) {
            $membersQuery->where(function ($q) use ($request) {
                $q->where('npm', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('no_hp', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status') || $request->get('status') === null) {
            $membersQuery->where('status', $request->get('status', 'aktif'));
        }

        $membersAll = $membersQuery->get();
        // ambil semua member aktif
        $members = Member::where('status', 'aktif')->get();
        $tahun = $request->get('tahun', now()->year);

        foreach ($members as $member) {

            $memberAda = Iuran::where('member_id', $member->id)
                ->where('tahun', $tahun)
                ->exists();

            if (!$memberAda) {
                for ($bulan = 1; $bulan <= 12; $bulan++) {
                    Iuran::create([
                        'member_id' => $member->id,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'jumlah' => ($bulan == 1) ? 10000 : 5000,
                        'status' => 'belum_lunas'
                    ]);
                }
            }
        }

        // tampilkan data iuran
        $iurans = Iuran::with('member')
            ->where('tahun', $tahun)
            ->orderBy('member_id')
            ->orderBy('bulan')
            ->get();

        $totalIuran = Iuran::count();
        $belumLunas = Iuran::where('status', 'belum_lunas')->count();

        return view('bendum.iuran.iuran', compact('iurans', 'tahun', 'members', 'tahun', 'belumLunas', 'totalIuran', 'membersAll', 'status'));
    }


    public function create() {}

    public function store(Request $request)
    {
        // make validation
        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
            'bulan' => 'required',
            'tahun' => 'required|digits:4',
            'jumlah' => 'required|numeric|min:0|max:99999999999999.99',
            'tanggal_bayar' => 'nullable|date',
            'metode_bayar' => 'nullable',
            'bukti' => 'nullable|image|max:1024',
            'status' => 'required'
        ], [
            'jumlah.max' => 'Jumlah terlalu besar! Maksimal Rp 99.999.999.999.999,99',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'tahun.max' => 'Format tahun salah.',
            'bukti.max' => 'Ukuran foto maksimal 1 MB.',
            'bukti.mimes' => 'Foto harus memiliki format gambar.'

        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }


        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $filename = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $file->getClientOriginalName();
            $file->storeAs('Iuran', $filename, 'public');
            $validatedData['bukti'] = $filename;
        }

        // simpan data
        Iuran::create($validatedData);

        // redirect
        return redirect('iuran.index');
    }


    public function show()
    {
        return view('bendum.iuran.iuran');
    }

    public function edit(Iuran $iuran)
    {
        return view('bendum.iuran.edit-iuran', compact('iuran'));
    }

    public function update(Request $request, Iuran $iuran)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'nullable',
            'bulan' => 'nullable',
            'tahun' => 'nullable|digits:4',
            'jumlah' => 'nullable|numeric|min:0|max:99999999999999.99',
            'tanggal_bayar' => 'nullable|date',
            'metode_bayar' => 'nullable',
            'bukti' => 'nullable|image|max:1024',
            'status' => 'required'

        ], [
            'jumlah.max' => 'Jumlah terlalu besar! Maksimal Rp 99.999.999.999.999,99',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'tahun.max' => 'Format tahun salah.',
            'bukti.max' => 'Ukuran foto maksimal 1 MB.',
            'bukti.mimes' => 'Foto harus memiliki format gambar.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        try {
            // update validation
            $validatedData = $validator->validate();
            $isChanged = false;

            $mainFields = ['member_id', 'bulan', 'tahun', 'jumlah', 'tanggal_bayar', 'metode_bayar', 'status'];
            foreach ($mainFields as $field) {
                if ($request->filled($field) && $iuran->$field != $request->$field) {
                    $isChanged = true;
                    break;
                }
            }


            if ($request->hasFile('bukti')) {
                if ($iuran->bukti) {
                    Storage::disk('public')->delete('Iuran/' . $iuran->bukti);
                }
                $foto = $request->file('bukti');
                $filename = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $foto->getClientOriginalName();
                $foto->storeAs('Iuran', $filename, 'public');
                $validatedData['bukti'] = $filename;
            }

            // update data
            $iuran->update($validatedData);

            // return redirect
            if ($isChanged) {
                return redirect()->route('iurandetail.show', $iuran->member_id)->with('success', 'Data berhasil diperbarui.');
            }
            return redirect()->route('iurandetail.show', $iuran->member_id)->with('info', 'Tidak ada perubahan data.');
        } catch (Exception $e) {
            return redirect()
            ->route('iurandetail.show', $iuran->member_id)
            ->with('error', 'Gagal memperbarui data. Silahkan coba lagi.');
        }
    }

    public function destroy($id)
    {
        $hapusIuran = Iuran::findOrFail($id);

        // hapus file bukti
        if ($hapusIuran->bukti && Storage::disk('public')->exists('Iuran/' . $hapusIuran->bukti)) {
            Storage::disk('public')->delete('Iuran/' . $hapusIuran->bukti);
        }
        $hapusIuran->delete();
        return redirect()->route('iuran.index');
    }
}
