<?php

namespace App\Product;

use App\Models\Day;
use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDayMeal extends Meal
{
    use HasFactory;

    protected $table = 'products_day_meal';
    protected $fillable = [
        'product_living_mission_id',
        'day_id',
        'meal_id',
    ];

    public static function howMealPerDay($productLivingMissionId, $dayId)
    {
        return ProductDayMeal::where('day_id', $dayId)->where('product_living_mission_id',
            $productLivingMissionId)->count();
    }

    public function ProductLivingMission()
    {
        return $this->belongsTo(ProductLivingMission::class);
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
