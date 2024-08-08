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
        'email',
        'is_sent_email',
        'is_read_email',
        'eror_email',
        'onesignal',
        'is_sent_onesignal',
        'is_read_onesignal',
        'eror_onesignal',
        'read_at',
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
    ];

    public static function boot()
    {
        parent::boot();

        // Automatically generate UUID for message_id when creating a new notification
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
