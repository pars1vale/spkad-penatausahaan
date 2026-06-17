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
        Schema::create('rkud', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_rkud')->nullable();
            $table->bigInteger('id_daerah')->nullable();

            $table->foreignId('id_bank')->constrained('bank')->cascadeOnDelete();
            $table->string('nama_bank');

            $table->foreignId('id_jenis_rkud')->constrained('jenis_rkud')->cascadeOnDelete();
            $table->string('nama_jenis_rkud');

            $table->string('no_rekening', 50);
            $table->string('nama_rekening', 255);

            $table->tinyInteger('is_locked')->default(0);

            $table->timestamps();

            $table->index('id_rkud');
            $table->index('id_bank');
            $table->index('id_jenis_rkud');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rkud');
    }
};
