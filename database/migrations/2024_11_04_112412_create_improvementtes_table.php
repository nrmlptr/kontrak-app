<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('improvementtes', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_pr')->nullable();
            $table->date('tgl_rilis3');
            $table->string('nomor_sop')->nullable();
            $table->date('tgl_sop');
            $table->integer('hasil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('improvementtes');
    }
};
