<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegate extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'name',
        'benefits',
        'institution',
        'rank',
        'food_type_id',
    ];
}
