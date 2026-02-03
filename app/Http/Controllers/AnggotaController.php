<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    public function store(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();
        // validate data
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email'    => 'required|email|max:100|unique:anggotas,email',
            'password' => 'required|min:8',
            'level' => 'required',
            'photo' => 'nullable|image|max:2048'
        ]);

        // hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

         // upload photo jika ada
        if ($request->hasFile('photo')) {
            $foto = $request->file('photo');
            $fotoname = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $foto->getClientOriginalName();
            $foto->storeAs('Profil/Anggota', $fotoname, 'public');
            $validatedData['photo'] = $fotoname;
        }

        // simpan data
        $anggota = Anggota::create($validatedData);
    }


    public function update(Request $request, $id)
    {
        try {
            // validate data
            $anggota = Anggota::findOrFail($id);
            $validatedData = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:100|unique:anggotas,email,' . $anggota->id,
                'password' => 'nullable|min:8',
                'level' => 'nullable',
                'photo' => 'nullable|image|max:2048'
            ]);
            $isChanged = false;
            $mainFields = ['name', 'email', 'password', 'level'];
            foreach ($mainFields as $field) {
                if ($request->filled($field) && $anggota->$field != $request->$field) {
                    $isChanged = true;
                    break;
                }
            }

            if ($request->filled('password')) {
                $validatedData['password'] = Hash::make($request->password);
            } else {
                unset($validatedData['password']);
            }

            // cek apakah user upload foto baru
            if ($request->hasFile('photo')) {
                // hapus file jika sudah ada

                if ($anggota->photo) {
                    Storage::disk('public')->delete('Profil/Anggota' . $anggota->photo);
                }

                // simpan ke file baru
                $foto = $request->file('photo');
                $fotoname = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $foto->getClientOriginalName();
                $foto->storeAs('Profil/Anggota', $fotoname, 'public');

                // simpan nama ke dalam database
                $validatedData['photo'] = $fotoname;
                $isChanged = true;
            }
            if ($isChanged) {
                // update data
                $anggota->update($validatedData);
                return redirect()->route('profil-anggota')->with('success', 'Data berhasil diperbarui.');
            }            
                return redirect()->route('profil-anggota')->with('info', 'Tidak ada perubahan data.');
        } catch (Exception $e) {
                return redirect()->route('profil-anggota')->with('error', 'Gagal memperbarui data.' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $hapusAnggota = Anggota::findOrFail($id);

        // hapus file bukti kalau ada
        if ($hapusAnggota->photo && Storage::disk('public')->exists('Profil/Anggota/' . $hapusAnggota->photo)) {
            Storage::disk('public')->delete('Profil/Anggota/' . $hapusAnggota->photo);
        }

        $hapusAnggota->delete();
    }

    public function updatePassword(Request $request)
    {
        /** @var \App\Models\Anggota $anggota */
        $anggota = Auth::guard('anggota')->user();

        try {

            $request->validate([
                'old_password' => 'required',
                'password' => 'required|min:8|confirmed'
            ]);

            // cek password lama
            if (!Hash::check($request->old_password, $anggota->password)) {
                return back()->with('error', 'Kata sandi lama salah.');
            }

            $anggota->password = Hash::make($request->password);
            $anggota->save();

            return back()->with('success', 'Kata sandi berhasil diperbarui.');

        } catch (Exception $e) {
            return back()->with('error', 'Konfirmasi kata sandi salah.');
        }
    }
}
