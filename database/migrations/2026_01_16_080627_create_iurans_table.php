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
        Schema::create('iurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onUpdate('cascade')->onDelete('restrict');            
            $table->tinyInteger('bulan');
            $table->year('tahun');
            $table->decimal('jumlah', 16, 2);
            $table->date('tanggal_bayar')->nullable();            
            $table->enum('metode_bayar', ['tunai', 'nontunai'])->nullable();
            $table->string('bukti')->nullable();
            $table->enum('status', ['lunas', 'belum_lunas'])->default('belum_lunas');
            $table->timestamps();
            $table->unique(['member_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iurans');
    }
};
