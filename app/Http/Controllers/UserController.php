<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'password' => [
                'nullable',
                Password::min(8)                    
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'level' => 'nullable',
            'photo' => 'nullable|image|max:2048'

        ], [
            'password.min' => 'Kata sandi minimal berisi 8 karakter',
            'password.mixedCase' => 'Kata sandi harus terdapat gabungan huruf besar dan kecil.',
            'password.numbers' => 'Kata sandi harus terdapat angka.',
            'password.symbols' => 'Kata sandi harus terdapat simbol',
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
            $validatedData = $validator->validate();
            $isChanged = false;
            $mainFields = ['name', 'email', 'password', 'level'];
            foreach ($mainFields as $field) {
                if ($request->filled($field) && $user->$field != $request->$field) {
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
                if ($user->photo) {
                    Storage::disk('public')->delete('Profil/User' . $user->photo);
                }

                // simpan ke file baru
                $foto = $request->file('photo');
                $fotoname = now('Asia/Jakarta')->format('d-m-Y_His') . '_' . $foto->getClientOriginalName();
                $foto->storeAs('Profil/User', $fotoname, 'public');

                // simpan nama ke dalam database
                $validatedData['photo'] = $fotoname;
                $isChanged = true;
            }
            if ($isChanged) {
                // update data
                $user->update($validatedData);

                if ($user->level == 'Sekretaris Umum')
                    return redirect()->route('profil-sekum')->with('success', 'Data berhasil diperbarui.');
                elseif ($user->level == 'Bendahara Umum')
                    return redirect()->route('profil-bendum')->with('success', 'Data berhasil diperbarui.');
            }
            if ($user->level == 'Sekretaris Umum')
                return redirect()->route('profil-sekum')->with('info', 'Tidak ada perubahan data.');
            elseif ($user->level == 'Bendahara Umum')
                return redirect()->route('profil-bendum')->with('info', 'Tidak ada perubahan data.');
        } catch (Exception $e) {
            if ($user->level == 'Sekretaris Umum')
                return redirect()->route('profil-sekum')->with('error', 'Gagal memperbarui data. Silahkan coba lagi.');
            elseif ($user->level == 'Bendahara Umum')
                return redirect()->route('profil-bendum')->with('error', 'Gagal memperbarui data. Silahkan coba lagi.');
        }
    }

    public function destroy($id)
    {
        $hapusUser = User::findOrFail($id);
        if ($hapusUser->photo && Storage::disk('public')->exists('Profil/User/' . $hapusUser->photo)) {
            Storage::disk('public')->delete('Profil/User/' . $hapusUser->photo);
        }
        $hapusUser->delete();
    }


    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('user')->user();

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
                'password.mixed' => 'Kata sandi harus terdapat gabungan huruf besar dan kecil.',
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
            $validated = $validator->validate();

            if (!Hash::check($request->old_password, $user->password)) {
                return back()->with('error', 'Kata sandi lama salah.');
            }
            $user->password = Hash::make($request->password);
            $user->save();

            return back()->with('success', 'Kata sandi berhasil diperbarui.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memperbarui kata sandi. Silahkan coba lagi.');
        }
    }
}
