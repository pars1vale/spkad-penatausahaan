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
        Schema::create('dpa_penerimaan_pendapatan', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('id_daerah')->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('id_skpd')->index();
            $table->string('kode_skpd', 50)->nullable();
            $table->string('nama_skpd', 255)->nullable();
            $table->bigInteger('nilai')->default(0);
            $table->bigInteger('nilai_rak')->default(0);
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->unique(['id_skpd', 'tahun'], 'unique_skpd_tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpa_penerimaan_pendapatan');
    }
};
