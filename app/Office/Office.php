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
    ];


    public function employeeOffice()
    {
        return $this->hasOne(EmployeeOffice::class);
    }
}
