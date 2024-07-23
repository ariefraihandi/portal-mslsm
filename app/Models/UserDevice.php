<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_token',
        'device_info',
        'status',
        'browser',
        'browser_version',
        'platform',
        'platform_version',
        'device',
        'brand',
        'is_mobile',
        'is_tablet',
        'is_desktop',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function deviceExists($deviceToken)
    {
        return self::where('device_token', $deviceToken)->exists();
    }
}

