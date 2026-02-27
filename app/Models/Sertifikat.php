<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    //
    protected $guarded = [];
    protected $table = 'sertifikats';

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
