<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyaratPerkaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syarat_perkara', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID sebagai primary key
            $table->uuid('id_perkara'); // Relasi ke tabel perkara
            $table->string('name_syarat'); // Nama syarat
            $table->text('discretion_syarat'); // Diskripsi syarat
            $table->string('url_syarat'); // URL syarat
            $table->integer('urutan')->default(0); // Kolom urutan
            $table->timestamps(); // created_at dan updated_at

            // Foreign key ke tabel perkara (asumsinya id pada perkara juga UUID)
            $table->foreign('id_perkara')->references('id')->on('perkara')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syarat_perkara');
    }
}
