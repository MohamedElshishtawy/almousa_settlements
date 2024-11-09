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
        'living_id',
    ];


    public function employeeOffice()
    {
        return $this->hasOne(EmployeeOffice::class);
    }

    public function living()
    {
        return $this->belongsTo(\App\Living\Living::class);
    }


    public function OfficeMissions()
    {
        return $this->HasMany(OfficeMission::class);
    }

    public function reports()
    {
        return $this->hasMany(\App\Report\Report::class);
    }

    /*
     * This function to return all time working for this office while Main mission or getting ready
     * */
    public static function dateRange($office)
    {
        if (!is_object($office)){
            $office = Office::find($office);
        }
        $dateRange = [];
        foreach ($office->missions as $mission) {
            $endDate = $mission->end_date;
            $currentDate = $mission->start_date;
            while (strtotime($currentDate) <= strtotime($endDate)) {
                $dateRange[] = $currentDate;
                $currentDate = date("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
            }
        }
        return $dateRange;
    }

}
