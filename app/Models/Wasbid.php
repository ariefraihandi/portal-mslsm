<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str; // Tambahkan ini untuk menggunakan Str::uuid()

class Wasbid extends Model
{
    use HasFactory, HasUuids;

    // Nama tabel yang digunakan oleh model
    protected $table = 'wasbid';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'tgl',
        'bidang',
        'subbidang',
        'tajuk',
        'kondisi',
        'kriteria',
        'sebab',
        'akibat',
        'rekomendasi',
        'pengawas',
        'eviden',
        'penanggung',
        'date_created',
    ];

    // Jika kolom 'id' menggunakan UUID
    protected $keyType = 'string';
    public $incrementing = false;

    // Jika Anda tidak menggunakan kolom 'created_at' dan 'updated_at'
    public $timestamps = true;

    // Tanggal yang akan dikelola oleh Laravel secara otomatis
    protected $dates = ['tgl', 'date_created'];

    // Menambahkan boot method untuk meng-generate UUID
    protected static function boot()
    {
        parent::boot();

        // Menambahkan UUID secara otomatis ketika model baru dibuat
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
