<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PHPUnit\TextUI\Configuration\Php;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::guard('user')->user();
        // validate data
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email'    => 'required|email|max:100|unique:users,email',
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
            $foto->storeAs('Profil/User', $fotoname, 'public');
            $validatedData['photo'] = $fotoname;
        }

        // simpan data
        $user = User::create($validatedData);
    }


    public function update(Request $request, User $user)
    {
        try {
            // validate data
            $validatedData = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:100|unique:users,email,' . $user->id,
                'password' => 'nullable|min:8',
                'level' => 'nullable',
                'photo' => 'nullable|image|max:2048'
            ]);
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

            // cek apakah user upload foto baru
            if ($request->hasFile('photo')) {
                // hapus file jika sudah ada

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
                return redirect()->route('profil-sekum')->with('error', 'Gagal memperbarui data.' . $e->getMessage());
            elseif ($user->level == 'Bendahara Umum')
                return redirect()->route('profil-bendum')->with('error', 'Gagal memperbarui data.' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $hapusUser = User::findOrFail($id);

        // hapus file bukti kalau ada
        if ($hapusUser->photo && Storage::disk('public')->exists('Profil/User/' . $hapusUser->photo)) {
            Storage::disk('public')->delete('Profil/User/' . $hapusUser->photo);
        }

        $hapusUser->delete();
    }


    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('user')->user();

        try {

            $request->validate([
                'old_password' => 'required',
                'password' => 'required|min:8|confirmed'
            ]);

            // cek password lama
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->with('error', 'Kata sandi lama salah.');
            }

            // update password baru (pakai save biar ga merah IDE)
            $user->password = Hash::make($request->password);
            $user->save();

            return back()->with('success', 'Kata sandi berhasil diperbarui.');

        } catch (Exception $e) {
            return back()->with('error', 'Konfirmasi kata sandi salah.');
        }
    }
}
