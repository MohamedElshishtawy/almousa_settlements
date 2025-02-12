<?php

namespace App\Models;

use App\DelegateAbcence\DelegateAbsence;
use App\Office\Office;
use App\Product\FoodType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelegateHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'delegate_id',
        'number',
        'name',
        'benefits',
        'institution',
        'rank',
        'food_type_id',
        'office_id',
        'phone',
        // not used
        'address',
        'start_date',
        'end_date',
        'is_active',
        // used
        'affected_at',
        'terminated_at'
    ];

    protected $table = 'delegate_histories';

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function dryFoodReports()
    {
        return $this->hasMany(DryFoodReport::class);
    }

    public function rejects()
    {
        return view('papers.delegate-do-not-want');
    }

    public function delegateAbsences()
    {
        return $this->hasMany(DelegateAbsence::class);
    }

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }

    public function histories()
    {
        return $this->hasMany(DelegateHistory::class);
    }


}
