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
            $table->string('no_surat')->default(''); // Tambahkan default value
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('atasan_id');
            $table->unsignedBigInteger('atasan_dua_id');
            $table->string('jenis');
            $table->text('alasan');
            $table->date('tglawal');
            $table->date('tglakhir');
            $table->text('alamat');
            $table->string('status')->default('Pending'); // Default value
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
            $table->decimal('cuti_n', 10, 2)->default(0); // Default value
            $table->decimal('cuti_nsatu', 10, 2)->default(0); // Default value
            $table->decimal('cuti_ndua', 10, 2)->default(0); // Default value
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
