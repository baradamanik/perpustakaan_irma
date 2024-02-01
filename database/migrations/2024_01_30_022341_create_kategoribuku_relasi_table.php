<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategoribuku_relasi', function (Blueprint $table) {
            $table->id('kategoribukuid');
            $table->unsignedBigInteger('bukuid');
            $table->unsignedBigInteger('kategoriid');
            $table->timestamps();

            //Menambahkan foreign key ke table 'buku'
            $table->foreign('bukuid')->references('bukuid')->on('bukubuku')->onDelete('cascade');

            //Menambahkan foreign key ke table 'kategoribuku'
            $table->foreign('kategoriid')->references('kategoriid')->on('kategoribuku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategoribuku_relasi');
    }
};
