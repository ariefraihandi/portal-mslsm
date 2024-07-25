<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiSisa extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan oleh model ini (jika nama tabel tidak standar/berbeda)
    protected $table = 'cuti_sisa';

    // Tentukan kolom-kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'user_id',
        'cuti_n',
        'cuti_nsatu',
        'cuti_ndua',
        'cuti_sakit',
        'cuti_ap',
        'cuti_m',
        'cuti_b',
    ];

    // Relasi ke model User (asumsi Anda memiliki model User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
