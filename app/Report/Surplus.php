<?php

namespace App\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surplus extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'meal_id',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function meal()
    {
        return $this->belongsTo(\App\Models\Meal::class);
    }

    public function surplusProductErrors()
    {
        return $this->hasMany(SurplusProductError::class);
    }

    public function surplusFoodTypes()
    {
        return $this->hasMany(SurplusFoodType::class);
    }





}
