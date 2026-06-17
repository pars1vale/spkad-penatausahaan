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
        Schema::create('besaran_up', function (Blueprint $table) {
            $table->id();
            $table->integer('id_besaran_up')->nullable();
            $table->integer('id_daerah')->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('id_unit')->nullable();
            $table->integer('id_skpd')->nullable();
            $table->integer('id_sub_skpd')->nullable()->unique();
            $table->string('kode_skpd', 50)->nullable();
            $table->string('nama_skpd', 255)->nullable();
            $table->bigInteger('pagu')->default(0);
            $table->bigInteger('besaran_up')->default(0);
            $table->bigInteger('besaran_up_kkpd')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('besaran_up');
    }
};
