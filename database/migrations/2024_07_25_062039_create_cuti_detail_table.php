<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCutiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuti_detail', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('atasan_id')->nullable();
            $table->unsignedBigInteger('atasan_dua_id')->nullable();
            $table->string('jenis');
            $table->text('alasan');
            $table->date('tglawal');
            $table->date('tglakhir');
            $table->text('alamat');
            $table->string('status');
            $table->string('status_pim')->nullable();
            $table->unsignedBigInteger('id_sign')->nullable();
            $table->unsignedBigInteger('id_sign_atasan')->nullable();
            $table->unsignedBigInteger('id_sign_atasan_dua')->nullable();
            $table->date('tglawal_per_atasan')->nullable();
            $table->date('tglakhir_per_atasan')->nullable();
            $table->text('keterangan_atasan')->nullable();
            $table->date('tglawal_per_atasan_dua')->nullable();
            $table->date('tglakhir_per_atasan_dua')->nullable();
            $table->text('keterangan_atasan_dua')->nullable();            
            $table->integer('cuti_n')->default(0);
            $table->integer('cuti_nsatu')->default(0);
            $table->integer('cuti_ndua')->default(0);
            $table->timestamps();

            // Foreign key constraints (if necessary)
            // $table->foreign('id_pegawai')->references('id')->on('pegawai');
            // $table->foreign('id_ataslang')->references('id')->on('ataslang');
            // $table->foreign('id_pimpinan')->references('id')->on('pimpinan');
            // $table->foreign('id_sign')->references('id')->on('signatures');
            // $table->foreign('id_sign_atas_lang')->references('id')->on('signatures');
            // $table->foreign('id_sign_pimpinan')->references('id')->on('signatures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuti_detail');
    }
}
