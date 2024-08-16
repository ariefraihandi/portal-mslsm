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
            $table->uuid('id')->primary();
            $table->string('no_surat')->default('');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('atasan_id');
            $table->unsignedBigInteger('atasan_dua_id');
            $table->string('jenis');
            $table->text('alasan');
            $table->date('tglawal');
            $table->date('tglakhir');
            $table->text('alamat');
            $table->string('status')->nullable(); // Default value
            $table->string('status_pim')->nullable();
            $table->string('id_sign')->nullable();
            $table->string('id_sign_atasan')->nullable();
            $table->string('id_sign_atasan_dua')->nullable();
            $table->date('tglawal_per_atasan')->nullable();
            $table->date('tglakhir_per_atasan')->nullable();
            $table->text('keterangan_atasan')->nullable();
            $table->date('tglawal_per_atasan_dua')->nullable();
            $table->date('tglakhir_per_atasan_dua')->nullable();
            $table->text('keterangan_atasan_dua')->nullable();
            $table->string('cuti_n')->default(0); // Default value
            $table->string('cuti_nsatu')->default(0); // Default value
            $table->string('cuti_ndua')->default(0); // Default value
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('atasan_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('atasan_dua_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cuti_detail');
    }
}
