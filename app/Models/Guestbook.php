<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guestbook extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi penamaan Laravel
    protected $table = 'guestbooks';

    // Tentukan kolom-kolom yang bisa diisi secara massal
    protected $fillable = [
        'name',
        'pekerjaan',
        'satker',
        'tujuan',
        'ditemui',
        'image',
        'signature',
    ];
}
