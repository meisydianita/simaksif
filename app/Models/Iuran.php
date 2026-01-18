<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    protected $guarded = [];
    protected $table = 'iurans';
     public function member()
    {
        return $this->belongsTo(Member::class);
    }

}
