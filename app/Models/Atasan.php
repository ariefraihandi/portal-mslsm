<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atasan extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan oleh model ini (jika nama tabel tidak standar/berbeda)
    protected $table = 'atasans';

    // Tentukan kolom-kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'user_id',
        'atasan_id',
        'atasan_dua_id',
    ];

    // Relasi ke model User (asumsi Anda memiliki model User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}