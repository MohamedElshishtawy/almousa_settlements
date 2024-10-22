<?php

namespace App\Models;

class Employee extends User
{

    protected $table = 'users';

    public function employeeOffice()
    {
        return $this->hasOne(EmployeeOffice::class, 'user_id');
    }




}
