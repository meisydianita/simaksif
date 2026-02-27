<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AnggotaController extends Controller
{
    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        // validate data

        $validator = Validator::make($request->all(), [
            'npm' => 'required|string|max:9',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:anggotas,email,' . $anggota->id,
            'password' => [
                'nullable',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'level' => 'nullable',
            'photo' => 'nullable|image|max:1024'
        ], [
            'password.min' => 'Kata sandi minimal berisi 8 karakter',
            'password.mixedCase' => 'Kata sandi harus terdapat huruf besar dan kecil.',
            'password.numbers' => 'Kata sandi harus terdapat angka.',
            'password.symbols' => 'Kata sandi harus terdapat simbol',
            'npm.max' => 'Npm maksimal berisi 9 karakter',
            'name.required' => 'Nama lengkap harus diisi',
            'name.max' => 'Nama lengkap maksimal berisi 100 karakter',
            'email.unique' => 'Email sudah terdaftar.',
            'email.required' => 'Email harus diisi!',
            'email.max' => 'Email maksimal berisi 100 karakter',
            'email.email' => 'Format email tidak valid'
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

            if ($request->hasFile('photo')) {

                if ($anggota->photo) {
                    Storage::disk('public')->delete('Profil/Anggota' . $anggota->photo);
                }
                $foto = $request->file('photo');
                $fotoname = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $foto->getClientOriginalName();
                $foto->storeAs('Profil/Anggota', $fotoname, 'public');
                $validatedData['photo'] = $fotoname;
                $isChanged = true;
            }
            if ($isChanged) {
                // update data
                $anggota->update($validatedData);
                return redirect()->route('profil-anggota')->with('success', 'Data berhasil diperbarui.');
            }
            return redirect()
                ->route('profil-anggota')
                ->with('info', 'Tidak ada perubahan data.');
        } catch (Exception $e) {
            return redirect()
                ->route('profil-anggota')
                ->with('error', ['Gagal memperbarui data. Silakan coba lagi.']);
        }
    }

    public function destroy($id)
    {
        $hapusAnggota = Anggota::findOrFail($id);
        if ($hapusAnggota->photo && Storage::disk('public')->exists('Profil/Anggota/' . $hapusAnggota->photo)) {
            Storage::disk('public')->delete('Profil/Anggota/' . $hapusAnggota->photo);
        }
        $hapusAnggota->delete();
    }

    public function updatePassword(Request $request)
    {
        /** @var \App\Models\Anggota $anggota */
        $anggota = Auth::guard('anggota')->user();

        $validator = Validator::make(
            $request->all(),
            [
                'old_password' => 'required',
                'password' => [
                    'confirmed',
                    'required',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],
            ],
            [
                'password.confirmed' => 'Konfirmasi kata sandi salah.',
                'password.min' => 'Kata sandi minimal berisi 8 karakter',
                'password.mixed' => 'Kata sandi harus terdapat huruf besar dan kecil.',
                'password.numbers' => 'Kata sandi harus terdapat angka.',
                'password.symbols' => 'Kata sandi harus terdapat simbol.',
            ]
        );
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        try {
            $validator = $validator->validate();

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
