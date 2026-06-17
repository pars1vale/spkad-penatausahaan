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
        Schema::create('pengajuan_rekening', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('id_pengajuan')->unique();
            $table->integer('id_daerah')->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('id_skpd')->nullable();
            $table->string('nama_skpd', 255)->nullable();

            $table->tinyInteger('is_persetujuan')->default(0);
            $table->integer('persetujuan_by')->nullable();
            $table->string('persetujuan_by_nama', 255)->nullable();
            $table->dateTime('waktu_mulai_jadwal')->nullable();

            $table->tinyInteger('is_aktif')->default(0);
            $table->integer('aktif_by')->nullable();
            $table->string('aktif_by_nama', 255)->nullable();
            $table->dateTime('aktif_at')->nullable();

            $table->integer('id_bank')->nullable();
            $table->string('nama_bank', 255)->nullable();
            $table->string('no_rekening', 100)->nullable();
            $table->string('nama_rekening', 255)->nullable();

            $table->bigInteger('saldo_tunai')->default(0);
            $table->bigInteger('saldo_bank')->default(0);

            $table->integer('created_by')->nullable();
            $table->string('created_by_nama', 255)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('updated_by_nama', 255)->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_rekening');
    }
};
