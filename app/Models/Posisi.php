<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posisi extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function userDetails()
    {
        return $this->hasMany(UserDetail::class, 'posisi', 'name');
    }
}