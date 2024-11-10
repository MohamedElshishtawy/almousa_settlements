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

    public function offices()
    {
        return view('admin.offices', [
            'offices' => Office::all()
        ]);
    }

    public function CreateOffice()
    {
        return view('admin.create-office');
    }

    public function EditOffice(Office $id)
    {
        return view('admin.create-office', [
            'office' => $id
        ]);
    }

    public function DeleteOffice(Office $id)
    {
        $id->delete();
        return redirect()->route('admin.offices')->with('message', 'تم حذف المقر بنجاح');
    }

}
