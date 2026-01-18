<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemasukans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemasukan');
            $table->date('tanggal_pemasukan');
            $table->enum('kategori', [
                'dana_universitas',
                'donasi_umum',
                'sumbangan_anggota',
                'usaha_kewirausahaan',
                'sponsor',
                'sisa_dana_kegiatan'
            ]);
            $table->string('sumber_pemasukan');
            $table->decimal('jumlah');
            $table->text('keterangan');
            $table->string('bukti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
    }
};
