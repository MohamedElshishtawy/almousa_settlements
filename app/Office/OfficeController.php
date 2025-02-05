<?php

namespace App\Office;

use App\Http\Controllers\Controller;

class OfficeController extends Controller
{
//    public function getInTimeRange()
//    {
//        return (new OfficeQuery\InTimeRange())->run();
//    }

    public function getOfficesForUser()
    {
        $offices = Office::all();
        $user = auth()->user();
        if (!$user->hasRole('admin') && $user->office) {
            $offices = $offices->filter(fn($office) => $user->office->id == $office->id);
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
