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
        Schema::create('perangkat_daerah', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_daerah');
            $table->integer('tahun');
            $table->bigInteger('id_skpd');
            $table->string('nama_skpd');
            $table->string('kode_skpd', '50');
            $table->bigInteger('nilai')->default(0);
            $table->bigInteger('nilai_rak')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perangkat_daerah');
    }
};
