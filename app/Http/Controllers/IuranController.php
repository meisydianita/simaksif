<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

            $sudahAda = Iuran::where('member_id', $member->id)
                ->where('tahun', $tahun)
                ->exists();

            if (!$sudahAda) {
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
        $validatedData = $request->validate([
            'member_id' => 'required',
            'bulan' => 'required',
            'tahun' => 'required|digits:4',
            'jumlah' => 'required|numeric|min:0|max:99999999999999.99',
            'tanggal_bayar' => 'nullable|date',
            'metode_bayar' => 'nullable',
            'bukti' => 'nullable|image|max:2048',
            'status' => 'required'
        ]);

        // upload bukti kalau ada
        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $filename = date('Y-m-d') . '_' . $file->getClientOriginalName();
            $file->storeAs('Iuran', $filename, 'public');
            $validatedData['bukti'] = $filename;
        }

        // simpan nama file ke database
        $validatedData['bukti'] = $filename;

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
        // update validation
        $validatedData = $request->validate([
            'member_id' => 'nullable',
            'bulan' => 'nullable',
            'tahun' => 'nullable|digits:4',
            'jumlah' => 'nullable|numeric|min:0|max:99999999999999.99',
            'tanggal_bayar' => 'nullable|date',
            'metode_bayar' => 'nullable',
            'bukti' => 'nullable|image|max:2048',
            'status' => 'required'
        ]);

        // cek apakah user upload foto baru
        if ($request->hasFile('bukti')) {

            // hapus file ketika sudah ada
            if ($iuran->bukti) {
                Storage::disk('public')->delete('Iuran/' . $iuran->bukti);
            }

            // simpan ke file baru
            $foto = $request->file('bukti');
            $fotoname = date('Y-m-d') . '_' . $foto->getClientOriginalName();
            $foto->storeAs('Iuran', $fotoname, 'public');

            // simpan nama ke dalam database
            $validatedData['bukti'] = $fotoname;
        }

        // update data
        $iuran->update($validatedData);

        // return redirect
        return redirect()->route('iurandetail.show', $iuran->member_id);
    }

    public function destroy(Iuran $iuran)
    {
        $iuran->delete();
        return redirect()->route('iuran.index');
    }
}
