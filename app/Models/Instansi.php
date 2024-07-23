<?php

// app/Models/Instansi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;
    
    protected $table = 'instansi';
    protected $fillable = [
        'name',
        'surname',
        'logo',
        'alamat',
        'profil',
        'email',
        'telp',
        'igusername',
        'tiktokusername',
        'fbusername',
    ];

    public function userDetails()
    {
        return $this->hasMany(UserDetail::class, 'instansi', 'id');
    }
}

