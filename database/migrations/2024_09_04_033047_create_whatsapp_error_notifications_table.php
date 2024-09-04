<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappErrorNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_error_notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID sebagai primary key
            $table->text('error_description'); // Deskripsi error
            $table->boolean('is_notified')->default(false); // Apakah sudah diberitahukan
            $table->timestamp('created_at')->useCurrent(); // Tanggal dibuat
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whatsapp_error_notifications');
    }
}
