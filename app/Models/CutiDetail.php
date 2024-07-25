<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiDetail extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan oleh model ini
    protected $table = 'cuti_detail';

    // Tentukan kolom-kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'no_surat',
        'user_id',
        'atasan_id',
        'atasan_dua_id',
        'jenis',
        'alasan',
        'tglawal',
        'tglakhir',
        'alamat',
        'status',
        'status_pim',
        'id_sign',
        'id_sign_atasan',
        'id_sign_atasan_dua',
        'tglawal_per_atasan',
        'tglakhir_per_atasan',
        'keterangan_atasan',
        'tglawal_per_atasan_dua',
        'tglakhir_per_atasan_dua',
        'keterangan_atasan_dua',
        'cuti_n',
        'cuti_nsatu',
        'cuti_ndua',
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi dengan model Atasan
    public function atasan()
    {
        return $this->belongsTo(Atasan::class, 'atasan_id');
    }

    public function atasanDua()
    {
        return $this->belongsTo(Atasan::class, 'atasan_dua_id');
    }

    // Relasi dengan model Signature (jika ada)
    public function sign()
    {
        return $this->belongsTo(Signature::class, 'id_sign');
    }

    public function signAtasan()
    {
        return $this->belongsTo(Signature::class, 'id_sign_atasan');
    }

    public function signAtasanDua()
    {
        return $this->belongsTo(Signature::class, 'id_sign_atasan_dua');
    }
}
