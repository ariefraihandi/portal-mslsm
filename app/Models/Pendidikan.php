<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's plural naming convention
    protected $table = 'pendidikan';

    // Define the fields that are mass assignable
    protected $fillable = ['name'];
}
