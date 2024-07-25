<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan oleh model ini
    protected $table = 'kehadiran';

    // Tentukan kolom-kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'user_id',
        'tgl_awal',
        'tgl_akhir',
        'jenis',
        'keterangan',
    ];

    // Relasi ke model User (jika diperlukan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
