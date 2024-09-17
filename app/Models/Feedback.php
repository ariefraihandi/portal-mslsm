<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Feedback extends Model
{
    use HasFactory;

    // Tentukan nama tabel (opsional jika nama tabel sesuai dengan konvensi Laravel)
    protected $table = 'feedback';

    // Gunakan UUID sebagai primary key
    protected $primaryKey = 'id';
    public $incrementing = false; // Karena UUID bukan auto-increment
    protected $keyType = 'string'; // UUID adalah string

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'id',
        'nama',
        'whatsapp',
        'email',
        'kritik',
        'saran',
        'image',
        'date_created'
    ];

    // Set default saat membuat UUID secara otomatis
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
