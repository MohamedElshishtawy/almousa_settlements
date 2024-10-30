<?php

namespace App\Office;

use App\Models\EmployeeOffice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'living_id',
        'mission_id'
    ];


    public function employeeOffice()
    {
        return $this->hasOne(EmployeeOffice::class);
    }

    public function living()
    {
        return $this->belongsTo(\App\Living\Living::class);
    }


    public function mission()
    {
        return $this->belongsTo(\App\Mission\Mission::class);
    }

    public function reports()
    {
        return $this->hasMany(\App\Report\Report::class);
    }

    public static function dateRange($office)
    {
        if (!is_object($office)){
            $office = Office::find($office);
        }
        $endDate = $office->end_date;
        $currentDate = $office->start_date;
        $dateRange = [];
        while (strtotime($currentDate) <= strtotime($endDate)) {
            $dateRange[] = $currentDate;
            $currentDate = date("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
        }
        return $dateRange;
    }

}
