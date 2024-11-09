<?php

namespace App\Office;

use App\Http\Controllers\Controller;
use App\Models\Employee;

class OfficeController extends Controller
{
//    public function getInTimeRange()
//    {
//        return (new OfficeQuery\InTimeRange())->run();
//    }

    public function getOfficesForUser()
    {
        $offices = Office::all();
        if (!auth()->user()->isAdmin()) {
            $employee = Employee::find(auth()->id());
            $offices = $offices->filter(fn ($office) => $employee->employeeOffice->office_id == $office->id );
        }
        return $offices;
    }
}
