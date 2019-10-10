<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomor_surat')->unique();
            $table->string('perihal');
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->string('pengirim');
            $table->string('tujuan');
            $table->date('tanggal_diterima');
            $table->date('tanggal_surat');
            $table->smallInteger('jumlah_lampiran');
            $table->json('file_surat')->nullable();
            $table->string('status');
            $table->unsignedSmallInteger('lemari_id')->nullable();
            $table->smallInteger('baris_lemari')->nullable();
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_masuk');
    }
}
