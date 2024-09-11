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
        Schema::create('lapkerma_ref_indikator_kinerjas', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('id_sasaran_kegiatan');
            $table->string('nama');
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
        Schema::dropIfExists('lapkerma_ref_indikator_kinerjas');
    }
};
