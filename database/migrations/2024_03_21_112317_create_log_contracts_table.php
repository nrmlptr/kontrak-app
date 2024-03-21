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
        Schema::create('log_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kontraks_id');
            $table->string('status');
            $table->foreignId('user_id');
            $table->timestamps();

            $table->index('kontraks_id');
            $table->index('status');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_contracts');
    }
};
