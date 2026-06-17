<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->unique();
            $table->string('nip')->unique();
            $table->string('password');
            $table->string('nik_user')->nullable();
            $table->string('npwp_user')->unique()->nullable();
            $table->date('lahir_user')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->unsignedBigInteger('id_pang_gol')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_pang_gol')
                ->references('id')
                ->on('pangkat_golongan')
                ->nullOnDelete();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
