<?php

namespace App\Product;

use App\Models\Day;
use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDayMeal extends Meal
{
    use HasFactory;

    protected  $table = 'products_day_meal';

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
