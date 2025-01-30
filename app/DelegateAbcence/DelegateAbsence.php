<?php

namespace App\DelegateAbcence;

use App\Models\Delegate;
use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelegateAbsence extends Model
{
    use HasFactory;

    protected $fillable = [
        'meal_id',
        'delegate_id',
        'for_date',
    ];


    public function delegate()
    {
        return $this->belongsTo(Delegate::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }


}
