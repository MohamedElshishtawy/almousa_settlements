<?php

namespace App\Obligations;

use App\Http\Controllers\Controller;
use App\Models\Employee;

class ObligationsController extends Controller
{
    public function index()
    {
        $employee = Employee::find(auth()->user()->id);
        $obligations = auth()->user()->isAdmin() ? Obligations::all() :
            Obligations::where('office_id', $employee->office()->id)->get();

        return view('obligations.index-obligations', compact('obligations'));
    }

    public function create()
    {
        return view('obligations.create-obligation');
    }

    public function edit($obligations)
    {
        $obligations = Obligations::find($obligations);
        return view('obligations.edit-obligation', compact('obligations'));
    }

    public function delete($obligation)
    {
        $obligation = Obligations::find($obligation);
        $obligation->delete();
        return redirect()->back()->with('success', 'تم حذف الالتزام بنجاح');
    }

}
