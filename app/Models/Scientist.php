<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scientist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'field',
        'specialization',
        'division',
        'year_awarded',
    ];
}
