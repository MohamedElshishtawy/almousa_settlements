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


    public function getOfficeMission($date)
    {
        return $this->OfficeMissions()->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)->first()->mission_id;
    }


    public function reports()
    {
        return $this->hasMany(\App\Report\Report::class);
    }

    public function delegates()
    {
        return $this->hasMany(\App\Models\Delegate::class);
    }

    public function obligations()
    {
        return $this->hasMany(\App\Obligations\Obligations::class);
    }

    public function tasks()
    {
        return $this->hasMany(\App\Task\Task::class);
    }


}
