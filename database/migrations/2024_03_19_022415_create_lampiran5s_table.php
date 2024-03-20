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
        Schema::create('lampiran5s', function (Blueprint $table) {
            $table->id();
            $table->string('kontraks_id', 11);
            $table->string('no_sppb');
            $table->string('nama_barang', 255);
            $table->float('harga_awal');
            $table->string('ppn');
            $table->float('harga_akhir');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampiran5s');
    }
};
