<?php

namespace App\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurplusFoodType extends Model
{
    use HasFactory;
    protected  $fillable = [
        'surplus_id',
        'food_type_id',
        'value',
    ];

    public function surplus()
    {
        return $this->belongsTo(Surplus::class);
    }

    public function food_type()
    {
        return $this->belongsTo(\App\Product\FoodType::class);
    }
}
