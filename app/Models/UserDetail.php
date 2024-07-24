<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'image',
        'jabatan',
        'nip',
        'whatsapp',
        'tlahir',
        'tglahir',
        'kelamin',
        'alamat',
        'instansi',
        'iguser',
        'fbuser',
        'twuser',
        'ttuser',
        'lastmodified',
        'posisi',
        'key',
    ];

    protected $table = 'users_detail'; // pastikan nama tabel sesuai

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi', 'id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan', 'name');
    }

}