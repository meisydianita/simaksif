<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaDokumenKegiatan extends Model
{
    protected $guarded = [];
    protected $table = 'dokumen_kegiatans';
    public function penanggungjawab()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
