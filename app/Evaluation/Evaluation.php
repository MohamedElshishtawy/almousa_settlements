<?php

namespace App\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'description',
    ];

    public static $descriptions = [
        'ممتاز',
        'جيد جدا',
        'جيد',
        'مقبول',
        'ضعيف',
    ];

    public function userEvaluates()
    {
        return $this->hasMany(UserEvaluate::class);
    }


}
