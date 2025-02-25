<?php

namespace App\Product;

use App\BreakFast\BreakFastProduct;
use App\Models\Day;
use App\Models\Meal;
use App\Office\Office;
use App\Office\OfficeMission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'food_type_id',
        'food_unit_id',
        'carton_value',
        'packet_value',
        'is_break_fast',
    ];

    // Relations Functions -----------------------

    public static function getProductMissionData(Product $product, Office $office, OfficeMission $officeMission)
    {
        return $product->productsLivingMission->where('living_id', $office->living_id)->where('mission_id',
            $officeMission->mission_id)->first();
    }

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }

    public function foodUnit()
    {
        return $this->belongsTo(FoodUnit::class);
    }

    // Get Functions -----------------------

    public function productsLivingMission()
    {
        return $this->hasMany(ProductLivingMission::class);
    }

    public function getHowManyDayPerWeekUsed(ProductLivingMission $productLivingMission)
    {
        return $productLivingMission->getHowManyPerWeek();
    }

    public function getAmountForMeal(Day $day, Meal $meal, ProductLivingMission $productLivingMission)
    {
        $isHasMeal = $productLivingMission->isHasMeal($day, $meal);
        dd($isHasMeal);
        if ($isHasMeal) {
            return $productLivingMission->daily_amount / $productLivingMission->getHowManyPerDay($day);
        }
        return 0;
    }

    public function getHowManyPerDay(Day $day, ProductLivingMission $productLivingMission)
    {
        return $productLivingMission->getHowManyPerDay($day);
    }

    public function breakFastProduct(): HasOne
    {
        return $this->hasOne(BreakFastProduct::class);
    }


}
