<?php

namespace App\Office;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeMission extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'office_id',
        'mission_id'
    ];

    public static function getMissionAtDate($officeId, $date)
    {
        return self::where('office_id', $officeId)
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();
    }

    public static function dateRange($officeMission)
    {
        if (!is_object($officeMission)) {
            $officeMission = OfficeMission::find($officeMission);
        }
        $dateRange = [];

        $endDate = $officeMission->end_date;
        $currentDate = $officeMission->start_date;
        while (strtotime($currentDate) <= strtotime($endDate)) {
            $dateRange[] = $currentDate;
            $currentDate = date("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
        }

        return $dateRange;
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function mission()
    {
        return $this->belongsTo(\App\Mission\Mission::class);
    }

}
