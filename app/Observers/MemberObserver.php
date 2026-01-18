<?php

namespace App\Observers;

use App\Models\Member;
use Carbon\Carbon;

class MemberObserver
{
    public function saving(Member $member)
    {
        $threeYearsAgo = Carbon::now()->subYears(3);
        if ($member->tahun_masuk < $threeYearsAgo->year && $member->status == 'aktif') {
            $member->status = 'tidak_aktif';
        }
        elseif ($member->tahun_masuk >= $threeYearsAgo && $member->status == 'tidak_aktif') {
            $member->status = 'aktif';
        }
    }
}
