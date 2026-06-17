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
        Schema::create('akun_penerimaan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_skpd');
            $table->integer('id_akun');
            $table->string('kode_akun', 50)->nullable();
            $table->string('nama_akun', 255)->nullable();
            $table->tinyInteger('is_checked')->default(0);
            $table->string('metode_input', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->primary('id');
            $table->unique(['id_skpd', 'id_akun'], 'unique_skpd_akun');
            $table->index('id_skpd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_penerimaan');
    }
};
