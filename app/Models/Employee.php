<?php

namespace App\Models;

class Employee extends User
{


    public function employeeOffice()
    {
        return $this->hasOne(EmployeeOffice::class);
    }




}
