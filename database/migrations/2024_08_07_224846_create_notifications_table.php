<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('message_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->string('type')->nullable();
            $table->json('data')->nullable();
            $table->string('whatsapp')->nullable();
            $table->boolean('is_sent_wa')->default(false);
            $table->boolean('is_read_wa')->default(false);
            $table->string('eror_wa')->default('');
            $table->string('count_sent_wa')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_sent_email')->default(false);
            $table->boolean('is_read_email')->default(false);
            $table->string('eror_email')->default(''); 
            $table->string('count_sent_email')->nullable();
            $table->string('onesignal')->nullable();
            $table->boolean('is_sent_onesignal')->default(false);
            $table->boolean('is_read_onesignal')->default(false);
            $table->string('eror_onesignal')->default('');
            $table->string('count_sent_onesignal')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('last_message_sent')->nullable(); // Menambahkan kolom last_message_sent
            $table->string('target_url')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
