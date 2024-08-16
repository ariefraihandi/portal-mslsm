<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'user_id',
        'message',
        'type',
        'data',
        'whatsapp',
        'is_sent_wa',
        'is_read_wa',
        'eror_wa',
        'count_sent_wa',
        'email',
        'is_sent_email',
        'is_read_email',
        'eror_email',
        'count_sent_onesignal',
        'onesignal',
        'is_sent_onesignal',
        'is_read_onesignal',
        'eror_onesignal',
        'count_sent_email',
        'read_at',
        'last_message_sent',  // Menambahkan kolom last_message_sent
        'target_url',  // Menambahkan kolom target_url
        'priority',
        'created_by',
    ];

    protected $casts = [
        'data' => 'array',
        'is_sent_wa' => 'boolean',
        'is_read_wa' => 'boolean',
        'is_sent_email' => 'boolean',
        'is_read_email' => 'boolean',
        'is_sent_onesignal' => 'boolean',
        'is_read_onesignal' => 'boolean',
        'read_at' => 'datetime',
        'last_message_sent' => 'datetime', // Menambahkan casting untuk kolom last_message_sent
    ];

    public static function boot()
    {
        parent::boot();

        // Secara otomatis menghasilkan UUID untuk message_id saat membuat notifikasi baru
        static::creating(function ($model) {
            $model->message_id = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
