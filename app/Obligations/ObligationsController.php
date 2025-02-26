<?php

namespace App\Obligations;

use App\Http\Controllers\Controller;
use App\Models\HijriDate;

class ObligationsController extends Controller
{
    public function index()
    {
        $user = auth()->user();


        $obligations = $user->office ? Obligations::where('office_id', $user->office->id)->get() : Obligations::all();


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

    public function printPage(Obligations $obligations)
    {
        $dateHijri = HijriDate::where('gregorian_date', $obligations->created_at->format('Y-m-d'))->first();
        return view('obligations.print-obligation', compact('obligations', 'dateHijri'));

    }

    public function delete($obligation)
    {
        $obligation = Obligations::find($obligation);
        $obligation->delete();
        return redirect()->back()->with('success', 'تم حذف الالتزام بنجاح');
    }

}
