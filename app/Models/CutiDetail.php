<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CutiDetail extends Model
{
    use HasFactory;

    protected $table = 'cuti_detail';

    // Jika menggunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;

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

    // Generate UUID saat membuat model baru
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function userDetails()
    {
        return $this->belongsTo(UserDetail::class, 'user_id', 'user_id');
    }
    

    // Relasi ke UserDetail (atasan pertama)
    public function atasan()
    {
        return $this->belongsTo(UserDetail::class, 'atasan_id', 'user_id');
    }

    // Relasi ke UserDetail (atasan kedua)
    public function atasanDua()
    {
        return $this->belongsTo(UserDetail::class, 'atasan_dua_id', 'user_id');
    }

    // Relasi ke tabel Cuti berdasarkan kode jenis cuti
    public function cuti()
    {
        return $this->belongsTo(Cuti::class, 'jenis', 'code');
    }

    // Relasi ke tabel Sign (tanda tangan pemohon)
    public function sign()
    {
        return $this->belongsTo(Sign::class, 'id_sign');
    }

    // Relasi ke tabel Sign (tanda tangan atasan pertama)
    public function signAtasan()
    {
        return $this->belongsTo(Sign::class, 'id_sign_atasan');
    }

    // Relasi ke tabel Sign (tanda tangan atasan kedua)
    public function signAtasanDua()
    {
        return $this->belongsTo(Sign::class, 'id_sign_atasan_dua');
    }
}
