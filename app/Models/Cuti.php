<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan oleh model ini
    protected $table = 'cuti';

    // Tentukan kolom-kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'name',
        'code',
        'jumlah',
    ];
}
