<?php

namespace App\Models;

use Alkoumi\LaravelArabicNumbers\Numbers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HijriDate extends Model
{
    use HasFactory;

    protected $fillable = ['gregorian_date', 'year', 'month', 'month_name', 'day', 'weekday'];

    public static $hijryMonths = [
        '1' => 'محرم',
        '2' => 'صفر',
        '3' => 'ربيع الأول',
        '4' => 'ربيع الثانى',
        '5' => 'جٌمّادى الأولى',
        '6' => 'جٌمّادى الآخرة',
        '7' => 'رجب',
        '8' => 'شعبان',
        '9' => 'رمضان',
        '10' => 'شوال',
        '11' => 'ذو القعدة',
        '12' => 'ذو الحجة',
    ];


    public static function formatedDate($date)
    {
        $higri = HijriDate::where('gregorian_date', $date)->first();
        $year = Numbers::ShowInArabicDigits($higri->year);
        $month = Numbers::ShowInArabicDigits($higri->month);
        $day = Numbers::ShowInArabicDigits($higri->day);
        return $year . '/' . $month . '/' . $day . ' هـ';
    }



}
