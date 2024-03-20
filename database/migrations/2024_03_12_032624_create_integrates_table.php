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
        Schema::create('integrates', function (Blueprint $table) {
            $table->id();
            $table->string('no_spph', 30)->nullable();
            $table->string('nama_tender', 255)->nullable();
            $table->double('nomor_po')->nullable();
            $table->date('tanggal_po')->nullable();
            $table->string('nomor_vendor')->nullable();
            $table->string('vendor_registration_number', 255)->nullable();
            $table->string('nama_vendor', 255)->nullable();
            $table->string('purchasing_group')->nullable();
            $table->string('kode_barang', 255);
            $table->string('nama_barang', 255);
            $table->string('quantity');
            $table->string('satuan');
            $table->string('nomor_pr');
            $table->string('harga_satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrates');
    }
};
