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
        Schema::create('kebijakan_spd', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_kebijakan_spd');
            $table->biginteger('id_daerah')->nullable();
            $table->bigInteger('tahun')->nullable();
            $table->foreignId('id_periode')->constrained('periode')->cascadeOnDelete()->nullable();
            $table->string('nama_periode', 100)->nullable();
            $table->foreignId('id_penerbitan_spd')->constrained('penerbitan_spd')->cascadeOnDelete()->nullable();
            $table->string('nama_penerbitan_spd')->nullable();
            $table->string('created_by_nama')->nullable();
            $table->string('updated_by_nama')->nullable();
            // $table->userstamps();
            $table->userstamps(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebijakan_spd');
    }
};
