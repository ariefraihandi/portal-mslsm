<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID sebagai primary key
            $table->string('nama');
            $table->string('whatsapp'); // Menambahkan kolom untuk nomor WhatsApp
            $table->string('email');
            $table->text('kritik')->nullable(); // Kritik boleh null
            $table->text('saran')->nullable(); // Saran boleh null
            $table->string('image')->nullable(); // Path gambar, boleh null
            $table->timestamp('date_created')->useCurrent(); // Waktu otomatis saat dibuat
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}
