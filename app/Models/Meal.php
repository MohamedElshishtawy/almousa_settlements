<?php

namespace App\Models;

use App\DelegateAbcence\DelegateAbsence;
use App\Mission\Mission;
use App\Product\ProductDayMeal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    static $meals = [
        'فطور',
        'غداء',
        'عشاء',
        'سحور',
    ];

    static $translateSmaller = [
        'فطور' => 'ف',
        'غداء' => 'غ',
        'عشاء' => 'ع',
        'سحور' => 'س',
    ];

    protected $fillable = ['name'];

    public static function getMealsFor(Mission $mission)
    {
        if ($mission->title == 'رمضان') {
            return Meal::whereNot('name', 'غداء')->get();
        }
        return Meal::whereNot('name', 'سحور')->get();
    }

    public function products_day_meal()
    {
        return $this->belongsTo(ProductDayMeal::class);
    }

    public function getMeals($for)
    {
        $meals = collect();
        foreach ($this->meals($for) as $meal) {
            $mealDB = Meal::where('name', $meal)->first();
            $mealDB ? $meals->push($mealDB) : null;
        }

        return $meals;
    }

    public function meals($for)
    {
        if (in_array($for, Mission::$missions)) {
            if ($for == 'رمضان') {
                return ['عشاء', 'سحور', 'فطور'];
            } else {
                if ($for == 'إفطار') {
                    return [];
                } else {
                    return ['عشاء', 'غداء', 'فطور'];
                }
            }
        }
        return null;
    }

    public function surpluses()
    {
        return $this->hasMany(\App\Report\Surplus::class);
    }

    public function surplus_meals()
    {
        return $this->hasMany(\App\Report\SurplusMeal::class);
    }

    public function delegateAbsences()
    {
        return $this->hasMany(DelegateAbsence::class);
    }
}
