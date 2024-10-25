<?php

namespace App\Models;

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

    public function products_day_meal()
    {
        return $this->belongsTo(ProductDayMeal::class);
    }

    public function meals($for)
    {
        if (in_array($for, Mission::$missions)) {
            return $for == 'رمضان' ? ['عشاء' ,'سحور', 'فطور'] : [ 'عشاء' ,'غداء','فطور'];
        }
        return null;
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

}
