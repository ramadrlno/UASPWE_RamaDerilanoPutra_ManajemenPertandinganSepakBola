<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePertandinganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertandingan', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('user_id'); // Foreign Key untuk user
            $table->string('tim_1', 100); // Nama tim 1
            $table->string('tim_2', 100); // Nama tim 2
            $table->integer('gol_tim_1')->default(0); // Gol tim 1
            $table->integer('gol_tim_2')->default(0); // Gol tim 2
            $table->text('pencetak_gol_tim_1')->nullable(); // Pencetak gol tim 1
            $table->text('pencetak_gol_tim_2')->nullable(); // Pencetak gol tim 2
            $table->enum('home_away', ['home', 'away']); // Status home/away
            $table->date('tanggal_pertandingan'); // Tanggal pertandingan
            $table->timestamps(); // Created at dan Updated at

            // Menambahkan foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pertandingan');
    }
}
