<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function postlogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // **TRIK: Cek di database dulu sebelum attempt**
        
        // 1. Cek apakah email ada di table users (Sekretaris/Bendahara)
        $userExists = \App\Models\User::where('email', $request->email)->exists();
        
        if ($userExists) {
            // Coba login sebagai user
            if (Auth::guard('user')->attempt($credentials)) {
                // Clear session anggota jika ada
                if (session('active_guard') === 'anggota') {
                    Auth::guard('anggota')->logout();
                }
                
                // Set session untuk user
                session(['active_guard' => 'user']);
                
                $user = Auth::guard('user')->user();
                if ($user->level == 'Sekretaris Umum') {
                    return redirect('/home');
                } else {
                    return redirect('/home-bendum');
                }
            }
        }
        
        // 2. Cek apakah email ada di table anggotas
        $anggotaExists = \App\Models\Anggota::where('email', $request->email)->exists();
        
        if ($anggotaExists) {
            // Coba login sebagai anggota
            if (Auth::guard('anggota')->attempt($credentials)) {
                // Clear session user jika ada
                if (session('active_guard') === 'user') {
                    Auth::guard('user')->logout();
                }
                
                // Set session untuk anggota
                session(['active_guard' => 'anggota']);
                
                return redirect('/home-anggota');
            }
        }
        
        return redirect('/login')->with('error', 'Email atau password salah');
    }

    public function postlogout(Request $request)
    {
        $guard = session('active_guard', 'user');
        
        Auth::guard($guard)->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Logout berhasil');
    }
}