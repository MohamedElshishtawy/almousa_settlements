<?php

namespace App\Product;

use App\Models\Day;
use App\Models\Meal;
use App\Report\ImportProductError;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'packet_value',
    ];

    // Appended attributes when model is converted to array or JSON
    protected $appends = [
        'total_imported',
        'number_per_week',
        'day_amount',
        'total_amount',
    ];

    /**
     * Accessor for total_imported
     * Calculates the total imported value
     */
    public function getTotalImportedAttribute()
    {
        $error = optional($this->importProductError)->error;
        $benefits = optional($this->report->import)->benefits ?? 0;
        $mealsPerDay = static::howMealPerDay($this->id, Day::date2object($this->report->for_date)->id);

        return $error ?: ($benefits * $this->daily_amount * $mealsPerDay);
    }

    /**
     * Accessor for number_per_week
     * Counts how many days the product is used per week
     */
    public function getNumberPerWeekAttribute()
    {
        return $this->getHowManyDayPerWeekUsed();
    }

    /**
     * Accessor for day_amount
     * Calculates the daily amount based on meals per day
     */
    public function getDayAmountAttribute()
    {
        $benefits = optional($this->report->import)->benefits ?? 0;
        $day = Day::date2object($this->report->for_date);
        $timesPerDay = static::howMealPerDay($this->id, $day->id);
        return $timesPerDay ? $this->daily_amount * $benefits : 0;
    }

    /**
     * Accessor for total_amount
     * Calculates the total amount by multiplying daily amount, benefits, and meals per day
     */
    public function getTotalAmountAttribute()
    {
        $day = Day::date2object($this->report->for_date);
        $benefits = optional($this->report->import)->benefits ?? 0;
        return $this->daily_amount * $benefits;
    }


    public function getAmountForMeal(Day $day, Meal $meal, ProductLivingMission $productLivingMission = null)
    {
        $isHasMeal = $productLivingMission->isHasMeal($day, $meal);
        if ($isHasMeal) {
            return $productLivingMission->daily_amount / $productLivingMission->getHowManyPerDay($day);
        }
        return 0;
    }


    // Relationships
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

    // Utility methods
    public static function howMealPerDay($productId, $dayId)
    {
        return StaticProductDayMeal::where('day_id', $dayId)
            ->where('static_product_id', $productId)
            ->count();
    }

    public function getHowManyDayPerWeekUsed(ProductLivingMission $productLivingMission = null)
    {
        return $this->productsDayMeal()
            ->select('day_id')
            ->groupBy('day_id')
            ->get()
            ->count();
    }

    public function getHowManyPerDay(Day $day, ProductLivingMission $productLivingMission = null)
    {
        return count(array_unique($this->productsDayMeal
            ->where('day_id', $day->id)
            ->pluck('meal_id')
            ->toArray()));
    }
}
