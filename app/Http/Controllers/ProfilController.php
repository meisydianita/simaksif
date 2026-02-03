<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function sekum()
    {
        $user = Auth::guard('user')->user();
        return view('sekum.profil.profil', compact('user'));
    }
    public function bendum()
    {
        $user = Auth::guard('user')->user();
        return view('bendum.profil.profil', compact('user'));
    }

    public function anggota()
    {
        $anggota = Auth::guard('anggota')->user();
        return view('anggota.profil', compact('anggota'));
    }

    public function editsekum(){
        $user = Auth::guard('user')->user();
        return view ('sekum.profil.edit-profil', compact('user'));
    }
    public function editbendum(){
        $user = Auth::guard('user')->user();
        return view ('bendum.profil.edit-profil', compact('user'));
    }
    public function editanggota(){
        $anggota = Auth::guard('anggota')->user();
        return view ('anggota.edit-profil', compact('anggota'));
    }

    public function passwordsekum(){
        $user = Auth::guard('user')->user();
        return view ('sekum.profil.ubah-kata-sandi', compact('user'));
    }
    public function passwordbendum(){
        $user = Auth::guard('user')->user();
        return view ('bendum.profil.ubah-kata-sandi', compact('user'));
    }
    public function passwordanggota(){
        $anggota = Auth::guard('anggota')->user();
        return view ('anggota.ubah-kata-sandi', compact('anggota'));
    }
    
}
