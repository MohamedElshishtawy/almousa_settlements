<?php

namespace App\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'expression',
        'ar_expression',
    ];

    //'جارى العمل', 'تم الانتهاء', 'مؤجل'
    public static $stages = [
        'done' => 'تم الانتهاء',
        'working' => 'جارى العمل',
        'postponed' => 'مؤجل',
    ];

    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
