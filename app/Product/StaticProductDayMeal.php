<?php

namespace App\Product;

use App\Models\Day;
use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaticProductDayMeal extends ProductDayMeal
{
    use HasFactory;

    protected  $table = 'static_products_day_meals';

    protected $fillable = [
        'product_id',
        'day_id',
        'meal_id',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }


    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

}
