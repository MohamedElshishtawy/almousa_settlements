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

    public static $daysTranslteEn2Ar = [
        'Saturday' => 'السبت',
        'Sunday' => 'الأحد',
        'Monday' => 'الاثنين',
        'Tuesday' => 'الثلاثاء',
        'Wednesday' => 'الأربعاء',
        'Thursday' => 'الخميس',
        'Friday' => 'الجمعة',
    ];

    public static function convertDate2ArName($date)
    {
        return self::$daysTranslteEn2Ar[date('l', strtotime($date))];
    }

    public static function text2object($dayText)
    {
        if (!in_array($dayText, self::$days)) {
            return null;
        }
        return Day::where('name', $dayText)->first();
    }

    public static function date2object($date)
    {
        $dayText = self::convertDate2ArName($date);
        return self::text2object($dayText);
    }


    public function products_day_meal()
    {
        return $this->belongsTo(ProductDayMeal::class);
    }
}
