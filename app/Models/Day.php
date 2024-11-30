<?php

namespace App\Models;

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Product\ProductDayMeal;
use http\Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

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

    public static function DateToHijri($gregorianDate)
    {
        $day = HijriDate::where('gregorian_date', $gregorianDate)->first();
        if (!$day->count()) {
            return $gregorianDate;
        }
        $dateFormat = date('d-m-Y', strtotime($gregorianDate));
        $arMonth = HijriDate::$hijryMonths[$day->month];
        return $day->week_day . ' ' . $day->day . ' ' . $arMonth .' '. $day->year ;
    }

    public static function DateToHijriSpecificArray($date)
    {
        $day = HijriDate::where('gregorian_date', $date)->first();
        if (!$day->count()) {
            // exception error
            return null;
            //throw new Exception('لا يوجد تاريخ فى الترجمة الهجرية | إنتقل الى صفحة ترجمة التاريخ الهجرى وترجم التاريخ أو تواصل مع الأدمن أو المبرمج التاريخ: '.$date);
        }

        return [
            'year' => $day->year,
            'month' => $day->month,
            'day' => $day->day,
            'day-text' => $day->week_day,
        ];
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
