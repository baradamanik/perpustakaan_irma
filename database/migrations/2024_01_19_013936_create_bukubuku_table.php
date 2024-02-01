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
        Schema::create('bukubuku', function (Blueprint $table) {
            $table->id('bukuid');
            $table->string('title', 250);
            $table->string('thumbnail', 250);
            $table->longText('description', 250);
            $table->string('penulis');
            $table->string('penerbit');
            $table->integer('tahun_terbit');
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bukubuku');
    }
};
