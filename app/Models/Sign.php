<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sign extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'message'];

    // Override the boot method to generate UUID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Specify that the primary key is not an incrementing integer
    public $incrementing = false;

    // Specify the primary key type
    protected $keyType = 'uuid';

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi dengan model UserDetail
    public function userDetail()
    {
        return $this->belongsTo(UserDetail::class, 'user_id', 'user_id');
    }
}
