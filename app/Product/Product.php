<?php

namespace App\Product;

use App\Models\Day;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'daily_amount',
        'food_type_id',
        'food_unit_id',
    ];

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }

    public function foodUnit()
    {
        return $this->belongsTo(FoodUnit::class);
    }

    public function pdoductsDayMeal()
    {
        return $this->hasMany(ProductDayMeal::class);
    }

    public function productsLivingMission()
    {
        return $this->hasMany(ProductLivingMission::class);
    }

    public static function howMealPerDay($productId ,$dayId)
    {
        return ProductDayMeal::where('day_id', $dayId)->where('product_id', $productId)->count();
    }

}
