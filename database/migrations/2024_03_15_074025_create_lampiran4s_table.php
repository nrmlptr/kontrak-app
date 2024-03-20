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
        Schema::create('lampiran4s', function (Blueprint $table) {
            $table->id();
            $table->string('kontraks_id', 11);
            $table->string('nomor_sop');
            $table->date('tanggal_sop');
            $table->string('jadwal_penyerahan_barang', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampiran4s');
    }
};
