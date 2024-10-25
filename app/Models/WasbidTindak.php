<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class WasbidTindak extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'wasbid_tindak';

    protected $fillable = [
        'id_wasbid',
        'tgl_tindak',
        'after',
        'eviden',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

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

    // Relasi dengan model Wasbid
    public function wasbid()
    {
        return $this->belongsTo(Wasbid::class, 'id_wasbid', 'id');
    }
}
