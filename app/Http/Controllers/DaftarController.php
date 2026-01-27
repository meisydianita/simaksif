<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;

class DaftarController extends Controller
{
    public function daftar()
    {
        return view('anggota.daftar');
    }

    public function postdaftar(Request $request)
    {
        // validated data
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:100|unique:anggotas,email',
                'password' => 'required|min:8|'
            ],
            [
                'name.required' => 'Nama lengkap harus diisi',
                'email.required' => 'Email harus diisi!',
                'email.max' => 'Email minimal berisi 100 karakter',
                'email.email' => 'Format email harus benar',
                'password.required' => 'Kata sandi harus diisi',
                'password.min' => 'Kata sandi minimal berisi 8 karakter',
            ]
        );

        Anggota::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'level' => 'Anggota'
        ]);

        return view('login');
    }
}
