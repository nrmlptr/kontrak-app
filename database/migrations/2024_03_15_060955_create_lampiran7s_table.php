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
        Schema::create('lampiran7s', function (Blueprint $table) {
            $table->id();
            $table->string('kontraks_id', 11);
            $table->string('alamat_vendor', 255);
            $table->string('alamat_peruri', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampiran7s');
    }
};
