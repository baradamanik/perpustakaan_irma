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
        Schema::create('koleksipribadi', function (Blueprint $table) {
            $table->id('koleksiid');
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('bukuid');
            $table->timestamps();

            //Menambahkan foreign key ke table 'user'
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            //Menambahkan foreign key ke table 'buku'
            $table->foreign('bukuid')->references('bukuid')->on('bukubuku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('koleksipribadi');
    }
};
