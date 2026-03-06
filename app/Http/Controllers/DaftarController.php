<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class DaftarController extends Controller
{
    public function daftar()
    {
        return view('anggota.daftar');
    }

    public function postdaftar(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [                
                'npm' => 'required|max:9|exists:members,npm|unique:anggotas,npm',
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:100|unique:anggotas,email',
                'password' => [
                    'required',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],
            ],
            [
                'npm.required' => 'NPM harus diisi.',
                'npm.max' => 'Npm maksimal berisi 9 karakter',
                'npm.exists' => 'NPM tidak terdaftar sebagai anggota HIMASIF.',
                'npm.unique' => 'NPM sudah memiliki akun.',
                'name.required' => 'Nama lengkap harus diisi',
                'name.max' => 'Nama lengkap maksimal berisi 100 karakter',
                'email.unique' => 'Email sudah terdaftar.',
                'email.required' => 'Email harus diisi!',
                'email.max' => 'Email maksimal berisi 100 karakter',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Kata sandi harus diisi',
                'password.min' => 'Kata sandi minimal berisi 8 karakter',
                'password.mixed' => 'Kata sandi harus terdapat huruf besar dan kecil.',
                'password.numbers' => 'Kata sandi harus terdapat angka.',
                'password.symbols' => 'Kata sandi harus terdapat simbol.',
            ]
        );

        if ($validator->fails()){
            return redirect()
            ->back()
            ->with('signup_error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        try {
            // validated data
            $validatedData = $validator->validate();

            Anggota::create([
                'npm' => $validatedData['npm'],
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'level' => 'Anggota'
            ]);

            return redirect('login')->with('signup_success', 'Pendaftaran berhasil. Silahkan masuk!');
        } catch (ValidationException $e) {
            $errors = collect($e->errors())->flatten()->implode('\n');
            return back()
                ->with('signup_error', 'Pendaftaran Gagal. \n' . $errors)
                ->withInput();
        }
    }
}
