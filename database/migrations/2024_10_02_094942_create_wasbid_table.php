<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasbidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wasbid', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('tgl'); // Tanggal
            $table->string('bidang'); // Bidang
            $table->string('subbidang'); // Subbidang
            $table->string('tajuk'); // Tajuk
            $table->string('kondisi'); // Kondisi
            $table->text('kriteria'); // Kriteria
            $table->text('sebab'); // Sebab
            $table->text('akibat'); // Akibat
            $table->text('rekomendasi'); // Rekomendasi
            $table->string('pengawas'); // Pengawas
            $table->string('eviden'); // Eviden
            $table->string('penanggung'); // Penanggung
            $table->timestamp('date_created')->useCurrent(); // Date Created
            $table->timestamps(); // Created at & Updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wasbid');
    }
}
