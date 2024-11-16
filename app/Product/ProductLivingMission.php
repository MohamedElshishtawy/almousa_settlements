<?php

namespace App\Product;

use App\Living\Living;
use App\Mission\Mission;
use App\Models\Day;
use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLivingMission extends Model
{
    use HasFactory;

    protected $table = 'products_living_mission';

    protected $fillable = [
        'product_id',
        'living_id',
        'mission_id',
        'price',
        'daily_amount',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function living()
    {
        return $this->belongsTo(Living::class);
    }

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function productsDayMeal()
    {
        return $this->hasMany(ProductDayMeal::class);
    }


    public function getHowManyPerDay(Day $day)
    {
        return count(array_unique($this->productsDayMeal->where('day_id', $day->id)->pluck('meal_id')->toArray()));
    }

    public function getHowManyPerWeek()
    {

        return $this->productsDayMeal->select('day_id')->groupBy('day_id')->count();
    }


    public function isHasMeal(Day $day, Meal $meal)
    {
        return $this->productsDayMeal->where('day_id', $day->id)->where('meal_id', $meal->id)->first();
    }




}
