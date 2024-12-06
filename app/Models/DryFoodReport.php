<?php

namespace App\Models;

use App\Mission\Mission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DryFoodReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'delegate_id',
        'mission_id',
        'start_date',
        'end_date',
    ];

    public static $startDate = '2025-01-18';
    public static $endDate = '2025-03-31';

    public function delegate()
    {
        return $this->belongsTo(Delegate::class);
    }

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }


}
