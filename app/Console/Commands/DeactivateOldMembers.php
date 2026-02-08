<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use illuminate\Support\Carbon;

class DeactivateOldMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:deactivate-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menonaktifkan anggota yang lebih dari 3 tahun';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threeYearsAgo = Carbon::now()->subYears(4);
        
        $updated = Member::where('tahun_masuk', '<', $threeYearsAgo->year)
                        ->where('status', 'aktif')
                        ->update(['status' => 'tidak_aktif']);
        $this->info("{$updated} anggota di-deactivate!");
    }
}
