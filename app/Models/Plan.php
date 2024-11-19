<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    // Defina os campos que podem ser preenchidos
    protected $fillable = [
        'name',
        'description',
        'price',
    ];
}
