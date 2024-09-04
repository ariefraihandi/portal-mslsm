<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class WhatsappErrorNotification extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini
    protected $table = 'whatsapp_error_notifications';

    // Menentukan bahwa primary key adalah UUID
    protected $keyType = 'string';
    public $incrementing = false;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id',
        'error_description',
        'is_notified',
    ];

    // Secara otomatis mengisi UUID ketika membuat model baru
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    // Menonaktifkan timestamps jika hanya ada kolom created_at
    public $timestamps = false;

    // Mengatur format tanggal
    protected $dates = [
        'created_at',
    ];
}
