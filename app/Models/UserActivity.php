<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $table = 'users_activity';

    protected $fillable = [
        'user_id',
        'ip_address',
        'activity',
        'description',
        'device_info',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
