<?php

namespace App\Models;

use App\Office\Office;

class Employee extends User
{

    protected $table = 'users';

    public function employeeOffice()
    {
        return $this->hasOne(EmployeeOffice::class, 'user_id');
    }


    // return the office
    public function office()
    {
        $employeeOffice = $this->employeeOffice;
        return $employeeOffice ? $employeeOffice->office : null;
    }





}
