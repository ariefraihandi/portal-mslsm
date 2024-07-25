<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtasansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atasans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('atasan_id')->nullable();
            $table->unsignedBigInteger('atasan_dua_id')->nullable();
            $table->timestamps();

            // Jika ingin menambahkan foreign key constraints
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('atasan_id')->references('id')->on('atasans');
            // $table->foreign('atasan_dua_id')->references('id')->on('atasans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atasans');
    }
}
