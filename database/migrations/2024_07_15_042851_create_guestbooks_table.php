<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestbooksTable extends Migration
{
    public function up()
    {
        Schema::create('guestbooks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('pekerjaan');
            $table->string('satker');
            $table->string('tujuan');
            $table->string('ditemui');
            $table->string('image');
            $table->text('signature');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guestbooks');
    }
}
