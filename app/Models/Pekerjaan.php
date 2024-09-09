<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model
    protected $table = 'pekerjaan';

    // Define the attributes that are mass assignable
    protected $fillable = ['nama_pekerjaan'];

    // Add any relationships or additional methods here if needed
}
