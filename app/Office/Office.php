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

}
