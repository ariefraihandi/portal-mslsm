<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasbidTindakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wasbid_tindak', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('id_wasbid');
            $table->date('tgl_tindak'); // Tanggal Tindak Lanjut
            $table->text('after')->nullable(); // Catatan Setelah Tindak Lanjut
            $table->string('eviden')->nullable(); // File Eviden setelah tindak lanjut
            $table->timestamps(); // Otomatis menambahkan kolom created_at dan updated_at

            // Foreign key untuk menghubungkan dengan tabel wasbid
            $table->foreign('id_wasbid')->references('id')->on('wasbid')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wasbid_tindak');
    }
}
