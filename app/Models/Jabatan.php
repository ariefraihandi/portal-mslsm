<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit jika berbeda dari konvensi pluralisasi
    protected $table = 'jabatan'; // Nama tabel yang benar di database

    protected $fillable = ['name'];

    public function userDetails()
    {
        return $this->hasMany(UserDetail::class, 'jabatan', 'name');
    }
}
