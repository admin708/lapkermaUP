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
        Schema::create('data_mou_bentuk_kegiatan_kerjasamas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_mou');
            $table->string('nilai_kontrak');
            $table->string('volume_luaran');
            $table->string('volume_satuan');
            $table->text('keterangan');
            $table->integer('id_ref_bentuk_kegiatan');
            $table->integer('id_ref_sasaran_kegiatan');
            $table->integer('id_ref_indikator_kinerja');
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
        Schema::dropIfExists('data_mou_bentuk_kegiatan_kerjasamas');
    }
};
