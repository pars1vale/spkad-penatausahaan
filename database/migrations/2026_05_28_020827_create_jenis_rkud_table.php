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
        Schema::create('jenis_rkud', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_jenis_rkud')->nullable();
            $table->string('nama_jenis_rkud');
            $table->timestamps();

            $table->index('id_jenis_rkud');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_rkud');
    }
};
