<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCutiSisaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuti_sisa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('cuti_n')->default(0); // cuti tahun ini
            $table->integer('cuti_nsatu')->default(0); // cuti tahun lalu
            $table->integer('cuti_ndua')->default(0); // cuti dua tahun lalu
            $table->integer('cuti_sakit')->default(0); // cuti sakit
            $table->integer('cuti_ap')->default(0); // cuti acara pribadi
            $table->integer('cuti_m')->default(0); // cuti menikah
            $table->integer('cuti_b')->default(0); // cuti bersalin
            $table->timestamps();

            // Jika ingin menambahkan foreign key constraints
            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuti_sisa');
    }
}
