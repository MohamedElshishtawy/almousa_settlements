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
        'surplus',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function meal()
    {
        return $this->belongsTo(\App\Models\Meal::class);
    }

    public function surplus_product_errors()
    {
        return $this->hasMany(SurplusProductError::class);
    }

}
