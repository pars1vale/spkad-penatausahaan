<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistik_belanja_akun', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();

            $table->integer('id_daerah')->nullable();
            $table->integer('tahun')->nullable();

            // SKPD
            $table->integer('id_skpd')->nullable();
            $table->integer('id_sub_skpd')->nullable();
            $table->string('kode_sub_skpd', 50)->nullable()->comment('dari level 1');
            $table->string('nama_sub_skpd', 255)->nullable()->comment('dari level 1');
            $table->string('nama_skpd', 255)->nullable()->comment('dari skpd list');
            $table->string('kode_skpd', 50)->nullable()->comment('dari skpd list');

            // Bidang Urusan
            $table->integer('id_urusan')->nullable();
            $table->integer('id_bidang_urusan')->nullable();
            $table->string('kode_bidang_urusan', 20)->nullable()->comment('dari level 2');
            $table->string('nama_bidang_urusan', 255)->nullable()->comment('dari level 2');

            // Program
            $table->integer('id_program')->nullable();
            $table->string('kode_program', 20)->nullable()->comment('dari level 3');
            $table->string('nama_program', 500)->nullable()->comment('dari level 3');

            // Kegiatan
            $table->integer('id_giat')->nullable();
            $table->string('kode_giat', 30)->nullable()->comment('dari level 4');
            $table->text('nama_giat')->nullable()->comment('dari level 4');

            // Sub Kegiatan
            $table->integer('id_sub_giat')->nullable();
            $table->string('kode_sub_giat', 30)->nullable()->comment('dari level 5');
            $table->text('nama_sub_giat')->nullable()->comment('dari level 5');

            // Anggaran
            $table->bigInteger('anggaran')->default(0)->nullable();
            $table->bigInteger('realisasi_rencana')->default(0)->nullable();
            $table->bigInteger('realisasi_rill')->default(0)->nullable();

            // Akun
            $table->integer('id_unit')->nullable();
            $table->integer('id_rak_belanja')->nullable();
            $table->integer('id_akun')->nullable();
            $table->string('kode_akun', 50)->nullable();
            $table->string('nama_akun', 255)->nullable();

            // Blokir
            $table->tinyInteger('is_blokir')->default(0)->nullable();
            $table->timestamps();

            $table->unique(['id_daerah', 'tahun', 'id_rak_belanja'], 'uq_rak');
            $table->index('id_skpd', 'idx_id_skpd');
            $table->index('id_bidang_urusan', 'idx_id_bidang_urusan');
            $table->index('id_program', 'idx_id_program');
            $table->index('id_giat', 'idx_id_giat');
            $table->index('id_sub_giat', 'idx_id_sub_giat');
            $table->index('tahun', 'idx_tahun');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistik_belanja_akun');
    }
};
