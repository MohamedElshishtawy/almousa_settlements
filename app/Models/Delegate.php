<?php

namespace App\Models;

use App\Office\Office;
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
        'office_id',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function dryFoodReports()
    {
        return $this->hasMany(DryFoodReport::class);
    }
}
