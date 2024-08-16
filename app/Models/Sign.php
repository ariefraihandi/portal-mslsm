<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sign extends Model
{
    use HasFactory;

    // Tentukan kunci utama sebagai UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'message',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate UUID saat membuat model baru
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
