<?php

namespace App\Product;

use App\Models\Day;
use App\Models\Meal;
use App\Report\ImportProductError;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticProduct extends Product
{
    use HasFactory;
    protected $table = 'static_products';

    protected $fillable = [
        'old_id',
        'old_product_living_mission_old',
        'name',
        'price',
        'daily_amount',
        'food_type_id',
        'food_unit_id',
        'report_id',
        'carton_value',
    ];

    public function report()
    {
        return $this->belongsTo(\App\Report\Report::class);
    }

    public function productsDayMeal()
    {
        return $this->hasMany(StaticProductDayMeal::class);
    }

    public function importProductError()
    {
        return $this->hasOne(ImportProductError::class);
    }


    public function surplusProductError()
    {
        return $this->hasMany(\App\Report\SurplusProductError::class);
    }

    public static function howMealPerDay($productId ,$dayId)
    {
        return StaticProductDayMeal::where('day_id', $dayId)->where('static_product_id', $productId)->count();
    }


    // Get Functions -----------------------
    public function getHowManyDayPerWeekUsed(ProductLivingMission $productLivingMission = null)
    {
        return $this->productsDayMeal->select('day_id')->groupBy('day_id')->count();
    }

    public function getHowManyPerDay(Day $day, ProductLivingMission $productLivingMission = null)
    {
        // $productLivingMission (not used)
        return count(array_unique($this->productsDayMeal->where('day_id', $day->id)->pluck('meal_id')->toArray()));
    }

    public function getAmountForMeal(Day $day, Meal $meal, ProductLivingMission $productLivingMission = null)
    {
        $isHasMeal = $this->productsDayMeal->where('day_id', $day->id)->where('meal_id', $meal->id)->first();
        if ($isHasMeal) {
            return $this->daily_amount / $this->getHowManyPerDay($day);
        }
        return 0;
    }

    public function getSurplus($mealId=null)
    {
        foreach ($this->report->surplus as $surplus) {
            $mealPerDay = $this->productsDayMeal->where('day_id', \App\Models\Day::text2object(\App\Models\Day::$daysTranslteEn2Ar[Carbon::parse($this->report->for_date)->format('l')])->id)->count();
            $surplusFromType = $surplus->surplusFoodTypes->where('food_type_id', $this->food_type_id)->first();
            $surplusFromTypeValue = $surplusFromType ? $surplusFromType->value * $this->daily_amount / $mealPerDay : 0;
            $surplusFromSpecific = $surplus->surplusProductErrors->where('static_product_id', $this->id)->first();
            $surplusFromSpecificValue = $surplusFromSpecific? $surplusFromSpecific->surplus_amount + $surplusFromSpecific->surplus_benefits * $this->daily_amount / $mealPerDay : 0;
        }

        return $surplusFromSpecificValue + $surplusFromTypeValue;
    }
}
