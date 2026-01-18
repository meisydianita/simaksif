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
        Schema::create('kas_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengeluaran');
            $table->date('tanggal_pengeluaran');
            $table->enum('kategori', [
                'proker_skala_kecil',
                'proker_skala_besar',
                'dana_lain']);
            $table->decimal('jumlah', 16, 2);
            $table->string('penerima');
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
        Schema::dropIfExists('kas_keluars');
    }
};
