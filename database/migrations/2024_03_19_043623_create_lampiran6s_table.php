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
        Schema::create('lampiran6s', function (Blueprint $table) {
            $table->id();
            $table->string('kontraks_id', 11);
            $table->string('nomor_sop');
            $table->date('tanggal_sop');
            $table->string('no_kontrak');
            $table->date('date_kontrak');
            $table->string('jenis_pembayaran');
            $table->string('lama_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampiran6s');
    }
};
