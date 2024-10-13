<?php

namespace App\Models;

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

    protected $fillable = ['name'];

    public function products_day_meal()
    {
        return $this->belongsTo(ProductDayMeal::class);
    }
}
