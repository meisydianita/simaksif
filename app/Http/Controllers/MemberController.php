<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('npm', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('no_hp', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('alamat', 'like', '%' . $request->search . '%');
            });
        }

        $tahun_masuk = Member::select('tahun_masuk')
            ->distinct()
            ->orderBy('tahun_masuk', 'DESC')
            ->pluck('tahun_masuk', 'tahun_masuk')
            ->toArray();


        $jabatan = [
            'ketua_umum' => ' Ketua Umum',
            'sekretaris_umum' => 'Sekretaris Umum',
            'bendahara_umum' => 'Bendahara Umum',
            'kepala_divisi' => 'Kepala Divisi',
            'sekretaris_divisi' => 'Sekretaris Divisi',
            'anggota' => 'Anggota'
        ];

        $status = [
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif'
        ];

        $divisi = [
            'Kaderisasi' => 'Kaderisasi',
            'Kesekretariatan' => 'Kesekretariatan',
            'Mebiskraf' => 'Media Bisnis dan Kreatif',
            'PSDM' => 'Peningkatan Sumber Daya Mahasiswa',
            'PM' => 'Pengabdian Masyarakat',
            'Kerohanian' => 'Kerohanian'
        ];

        // filter tahun masuk
        if ($request->filled('tahun_masuk')) {
            $query->where('tahun_masuk', $request->tahun_masuk);
        }
        // filter divisi
        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }
        // filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $allmember = $query->paginate(5)->appends(request()->query());
        return view('sekum.member.anggota', compact('allmember', 'jabatan', 'status', 'tahun_masuk', 'divisi'));
    }
    public function create()
    {
        return view('sekum.member.add-anggota');
    }

    public function store(Request $request)
    {
        // data akan diproses di sini ketika disubmit (create)
        try {
            // validate data
            $validatedData = $request->validate([
                'npm' => 'required|string|max:16|unique:members,npm',
                'nama_lengkap' => 'required|string|max:100',
                'tahun_masuk' => 'required|digits:4',
                'jabatan' => 'required',
                'divisi' => 'nullable',
                'status' => 'required',
                'email' => 'required|email|max:100|unique:members,email',
                'no_hp' => 'required|string|regex:/^[0-9]{10,20}$/',
                'alamat' => 'required|string|max:255',
                'foto' => 'required|image|max:2048'
            ]);
            $foto = $request->file('foto');
            $fotoname = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $foto->getClientOriginalName();
            $foto->storeAs('Member', $fotoname, 'public');
            $validatedData['foto'] = $fotoname;
            $member = Member::create($validatedData);

            if ($member->status == 'aktif') {
                $tahun = now()->year;

                for ($bulan = 1; $bulan <= 12; $bulan++) {

                    $jumlah = ($bulan == 1) ? 10000 : 5000;

                    Iuran::firstOrCreate(
                        [
                            'member_id' => $member->id,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                        ],
                        [
                            'jumlah' => $jumlah,
                            'status' => 'belum_lunas'
                        ]
                    );
                }
            }

            // redirect to index ketika berhasil disimpan
            return redirect()->route('member.index')->with('success', 'Data berhasil ditambah.');
        } catch (Exception $e) {
            return redirect()->route('member.index')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show(Member $member)
    {
        return view('sekum.member.anggota', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('sekum.member.edit-anggota', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        try {
            // function yang memproses saat update disubmit
            // validate data
            $validatedData = $request->validate([
                'npm' => 'required|string|max:16|unique:members,npm,' . $member->id,
                'nama_lengkap' => 'required|string|max:100',
                'tahun_masuk' => 'required|digits:4',
                'jabatan' => 'required',
                'divisi' => 'required',
                'status' => 'required',
                'email' => 'required|email|max:100|unique:members,email,' . $member->id,
                'no_hp' => 'required|string|regex:/^[0-9]{10,20}$/',
                'alamat' => 'required|string|max:255',
                'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]);
            $isChanged = false;

            $mainFields = ['npm', 'nama_lengkap', 'tahun_masuk', 'jabatan', 'divisi', 'status', 'email', 'no_hp', 'alamat'];
            foreach ($mainFields as $field) {
                if ($request->filled($field) && $member->$field != $request->$field) {
                    $isChanged = true;
                    break;
                }
            }
            if ($request->hasFile('foto')) {
                if ($member->foto) {
                    Storage::disk('public')->delete('Member/' . $member->foto);
                }
                $foto = $request->file('foto');
                $fotoname = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $foto->getClientOriginalName();
                $foto->storeAs('Member', $fotoname, 'public');
                $validatedData['foto'] = $fotoname;
                $isChanged = true;
            }

            // update data
            $member->update($validatedData);

            if ($validatedData['status'] == 'aktif') {
                $tahun = now()->year;

                for ($bulan = 1; $bulan <= 12; $bulan++) {

                    $jumlah = ($bulan == 1) ? 10000 : 5000;

                    Iuran::firstOrCreate(
                        [
                            'member_id' => $member->id,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                        ],
                        [
                            'jumlah' => $jumlah,
                            'status' => 'belum_lunas'
                        ]
                    );
                }
            }
            // redirect to index ketika berhasil diupdate

            if ($isChanged) {
                return redirect()->route('member.index')->with('success', 'Data berhasil diperbarui.');
            }
            return redirect()->route('member.index')->with('info', 'Tidak ada perubahan data.');
        } catch (Exception $e) {
            return redirect()->route('member.index')->with('error', 'Gagal memperbarui data.' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $hapusMember = Member::findOrFail($id);
        if ($hapusMember->foto && Storage::disk('public')->exists('Member/' . $hapusMember->foto)) {
            Storage::disk('public')->delete('Member/' . $hapusMember->foto);
        }
        $hapusMember->delete();
        return redirect()->route('member.index');
    }
}
