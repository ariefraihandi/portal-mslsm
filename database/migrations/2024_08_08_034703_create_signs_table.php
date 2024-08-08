<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signs', function (Blueprint $table) {
            // Menggunakan UUID sebagai ID
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->timestamps();

            // Menambahkan foreign key ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Hapus foreign key ke tabel users_detail
            // $table->foreign('user_id')->references('user_id')->on('users_detail')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signs');
    }
}
