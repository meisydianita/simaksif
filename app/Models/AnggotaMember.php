<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaMember extends Model
{
    protected $guarded = [];
    protected $table = 'members';
    public function dokumenKegiatan()
    {
        return $this->hasMany(DokumenKegiatan::class, 'member_id');
    }
    public function iurans()
    {
        return $this->hasMany(Iuran::class);
    }
}
