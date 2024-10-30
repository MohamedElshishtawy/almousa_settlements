<?php

namespace App\Product;

use App\Report\ImportProductError;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticProduct extends Product
{
    use HasFactory;
    protected $table = 'static_products';

    protected $fillable = [
        'old_id',
        'name',
        'price',
        'daily_amount',
        'food_type_id',
        'food_unit_id',
        'report_id'
    ];

    public function report()
    {
        return $this->belongsTo(\App\Report\Report::class);
    }

    public function pdoductsDayMeal()
    {
        return $this->hasMany(StaticProductDayMeal::class);
    }

    public function importProductError()
    {
        return $this->hasOne(ImportProductError::class);
    }


    public function surplusProductError()
    {
        return $this->hasOne(\App\Report\SurplusProductError::class);
    }

    public static function howMealPerDay($productId ,$dayId)
    {
        return StaticProductDayMeal::where('day_id', $dayId)->where('static_product_id', $productId)->count();
    }

}
