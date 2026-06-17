<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pegawai')->unique();
            $table->integer('id_daerah')->nullable();
            $table->integer('id_skpd')->nullable();
            $table->integer('id_user')->nullable();
            $table->integer('id_role')->nullable();
            $table->string('nama_role', 100)->nullable();
            $table->integer('tahun_pegawai')->nullable();
            $table->integer('id_pegawai_kpa')->nullable();
            $table->string('status', 20)->nullable();
            $table->string('id_pegawai_ref', 20)->nullable();
            $table->integer('id_user_kpa')->nullable();
            $table->string('nama_user', 255)->nullable();
            $table->string('nip_user', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
