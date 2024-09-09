<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Perkara extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit
    protected $table = 'perkara';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'perkara_name',
        'perkara_jenis',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Set UUID saat model dibuat
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Override key type to string for UUID.
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * Disable auto-incrementing since UUID is not numeric.
     */
    public function getIncrementing()
    {
        return false;
    }

    public function syaratPerkara()
    {
        return $this->hasMany(SyaratPerkara::class, 'id_perkara');
    }
    
}
