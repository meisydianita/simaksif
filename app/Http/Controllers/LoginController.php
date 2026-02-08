<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function postlogin(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => 'Email harus diisi!',
                'email.max' => 'Email minimal berisi 100 karakter',
                'email.email' => 'Format email harus benar',
                'password.required' => 'Kata sandi harus diisi',
                'password.min' => 'Kata sandi minimal berisi 8 karakter',
            ]

        );
        $userExists = \App\Models\User::where('email', $request->email)->exists();

        if ($userExists) {
            if (Auth::guard('user')->attempt($credentials)) {
                if (session('active_guard') === 'anggota') {
                    Auth::guard('anggota')->logout();
                }

                session(['active_guard' => 'user']);

                $user = Auth::guard('user')->user();
                $welcomeMessage = "Selamat datang, " . $user->name . "!";

                $user = Auth::guard('user')->user();
                if ($user->level == 'Sekretaris Umum') {
                    return redirect('/beranda-sekum')
                    ->with('login_success_dashboard', $welcomeMessage);
                    
                } else {
                    return redirect(to: '/beranda-bendum')
                    ->with('login_success_dashboard', $welcomeMessage);
                    
                }
            }
        }


        $anggotaExists = \App\Models\Anggota::where('email', $request->email)->exists();

        if ($anggotaExists) {
            if (Auth::guard('anggota')->attempt($credentials)) {
                if (session('active_guard') === 'user') {
                    Auth::guard('user')->logout();
                }
                session(['active_guard' => 'anggota']);
                $user = Auth::guard('anggota')->user();
                $welcomeMessage = "Selamat datang, " . $user->name . "!";

                return redirect('/beranda-anggota')
                 ->with('login_success_dashboard', $welcomeMessage);
                    
            }
        }

        return redirect('/login')->with('login_error', 'Email atau kata sandi salah!');
    }

    public function postlogout(Request $request)
    {
        $guard = session('active_guard', 'user');

        Auth::guard($guard)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('logout', 'Logout berhasil. Sampai jumpa! ');

    }

    public function resetsandi (){
        return view ('auth.reset-kata-sandi');
    }

    
}
