<?php

namespace App\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluateWeek extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'name',
    ];

    public static $start_date = '2025-03-01';
    public static $names = [
        'الأسبوع الأول',
        'الأسبوع الثانى',
        'الأسبوع الثالث',
        'الأسبوع الرابع',
    ];

    public function userEvaluates()
    {
        return $this->hasMany(UserEvaluate::class);
    }

}
