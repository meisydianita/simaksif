<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarController extends Controller
{
    public function daftar(){
        return view ('anggota.daftar');
    }
}
