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
        Schema::create('players', function (Blueprint $table) {
            $table->id(); // ID utama pemain
            $table->string('name'); // Nama pemain
            $table->string('position'); // Posisi pemain (contoh: GK, DF, MF, FW)
            $table->string('team'); // Nama tim
            $table->integer('age'); // Usia pemain
            $table->integer('jersey_number')->unique(); // Nomor punggung unik
            $table->string('image')->nullable(); // Foto pemain
            $table->unsignedBigInteger('user_id'); // Relasi ke pengguna
            $table->timestamps();

            // Menambahkan foreign key untuk user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
