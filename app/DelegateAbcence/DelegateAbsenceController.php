<?php

namespace App\DelegateAbcence;

use App\Http\Controllers\Controller;

class DelegateAbsenceController extends Controller
{

    public function index()
    {
        return view('delegate-abcence.index');
    }

    public function printPage(DelegateAbsence $delegateAbcence)
    {
        return view('delegate-abcence.print', compact('delegateAbcence'));
    }

}
