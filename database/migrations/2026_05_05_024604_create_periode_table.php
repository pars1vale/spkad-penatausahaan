<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_periode')->nullable();
            $table->string('nama_periode');
            $table->timestamps();

            $table->index('id_periode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};
