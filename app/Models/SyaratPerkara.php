<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SyaratPerkara extends Model
{
    use HasFactory;

    protected $table = 'syarat_perkara'; // Nama tabel

    protected $fillable = [
        'name_syarat',
        'discretion_syarat',
        'url_syarat',
        'urutan',
        'id_perkara'
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

    /**
     * Relasi ke model Perkara (many to one)
     */
    public function perkara()
    {
        return $this->belongsTo(Perkara::class, 'id_perkara');
    }
}
