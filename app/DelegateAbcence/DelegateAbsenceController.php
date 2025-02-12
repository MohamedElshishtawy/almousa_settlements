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
        if (!auth()->user()->isBelongsToOffice($delegateAbcence->delegate->office->id)) {
            abort(403);
        }
        // get the delegate from the history
        $delegateAbcence->delegate = $delegateAbcence->delegate
            ->delegateFromHistory($delegateAbcence->created_at->format('Y-m-d'));
        return view('delegate-abcence.print', compact('delegateAbcence'));
    }

}
