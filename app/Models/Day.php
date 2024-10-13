<?php

namespace App\Models;

use App\Product\ProductDayMeal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    static $days = [
        'السبت',
        'الأحد',
        'الاثنين',
        'الثلاثاء',
        'الأربعاء',
        'الخميس',
        'الجمعة',
    ];
    protected $fillable = ['name'];

    public function products_day_meal()
    {
        return $this->belongsTo(ProductDayMeal::class);
    }
}
