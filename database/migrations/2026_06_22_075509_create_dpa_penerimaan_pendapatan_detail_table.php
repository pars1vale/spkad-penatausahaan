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
        Schema::create('dpa_penerimaan_pendapatan_detail', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('id_skpd')->index();
            $table->string('nama_skpd', 255)->nullable();
            $table->string('kode_skpd', 50)->nullable();
            $table->integer('id_daerah')->nullable();
            $table->integer('tahun')->nullable()->index();
            $table->integer('id_unit')->nullable();
            $table->integer('id_sub_skpd')->nullable();
            $table->string('kode_sub_skpd', 50)->nullable();
            $table->string('nama_sub_skpd', 255)->nullable();
            $table->integer('id_akun')->index();
            $table->string('kode_akun', 50)->nullable();
            $table->string('nama_akun', 255)->nullable();
            $table->bigInteger('nilai')->default(0);
            $table->bigInteger('nilai_rak')->default(0);
            $table->bigInteger('januari')->default(0)->comment('Bulan 1');
            $table->bigInteger('februari')->default(0)->comment('Bulan 2');
            $table->bigInteger('maret')->default(0)->comment('Bulan 3');
            $table->bigInteger('april')->default(0)->comment('Bulan 4');
            $table->bigInteger('mei')->default(0)->comment('Bulan 5');
            $table->bigInteger('juni')->default(0)->comment('Bulan 6');
            $table->bigInteger('juli')->default(0)->comment('Bulan 7');
            $table->bigInteger('agustus')->default(0)->comment('Bulan 8');
            $table->bigInteger('september')->default(0)->comment('Bulan 9');
            $table->bigInteger('oktober')->default(0)->comment('Bulan 10');
            $table->bigInteger('november')->default(0)->comment('Bulan 11');
            $table->bigInteger('desember')->default(0)->comment('Bulan 12');
            $table->integer('id_rak_pendapatan')->nullable();
            $table->tinyInteger('is_valid_skpd')->default(0);
            $table->tinyInteger('is_valid_sekda')->default(0);
            $table->tinyInteger('is_valid_bud')->default(0);
            $table->timestamps();

            $table->unique(['id_skpd', 'id_akun'], 'unique_skpd_akun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpa_penerimaan_pendapatan_detail');
    }
};
