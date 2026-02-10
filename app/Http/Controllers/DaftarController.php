<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Anggota;
use Illuminate\Http\Request;
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
        try{
            // validated data
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:100|unique:anggotas,email',
                'password' => [
                    'required',
                    Password::min(8)
                        ->letters()
                        ->numbers()
                        ->symbols()
                ],
            ],
            [
                'name.required' => 'Nama lengkap harus diisi',
                'name.max' => 'Nama lengkap maksimal berisi 100 karakter',
                'email.unique' => 'Email sudah terdaftar.',
                'email.required' => 'Email harus diisi!',
                'email.max' => 'Email maksimal berisi 100 karakter',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Kata sandi harus diisi',
                'password.min' => 'Kata sandi minimal berisi 8 karakter',
                'password.letters' => 'Kata sandi harus terdapat huruf.',
                'password.mixedCase' => 'Kata sandi harus terdapat huruf besar dan kecil.',
                'password.numbers' => 'Kata sandi harus terdapat angka.',
                'password.symbols' => 'Kata sandi harus terdapat simbol (!@#$%).',
            ]
        );

        Anggota::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'level' => 'Anggota'
        ]);

       return redirect('login')->with('signup_success', 'Pendaftaran sebagai anggota berhasil. Silahkan masuk!');
        }catch(ValidationException $e){
            $errors = collect($e->errors())->flatten()->implode('\n');        
        return back()
            ->with('signup_error', 'Pendaftaran Gagal. \n'. $errors)  
            ->withInput();
        }
        
    }
}
