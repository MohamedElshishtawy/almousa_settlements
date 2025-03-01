<?php

namespace App\Employment;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Report\Import;

class EmploymentController extends Controller
{
    public function employment()
    {
        return view('employment.index');
    }

    public function employmentForm(Import $import)
    {
        return view('employment.form-employment', compact('import'));
    }

    public function employmentFormPrint(Import $import)
    {
        $formEmployment = $import->formEmployment;
        $formEmploymentElements = $formEmployment->formEmploymentElements;

        $titleAndCountsArr = $formEmploymentElements->map(function ($formEmploymentElement) use ($import) {
            return [
                'title' => $formEmploymentElement->title,
                'real' => $formEmploymentElement->count,
                'expected' => $formEmploymentElement->getEmploymentRealCount(
                    $formEmploymentElement->benefits,
                    $formEmploymentElement->main_count,
                    $import->getBenefits()
                ),
            ];
        })->toArray();

        // sign data
        $office = $import->report->office;
        $subsidiary_receiving_committee_president = User::with('roles')->get()->filter(fn(
            $user
        ) => $user->office && $user->office->id == $office->id && $user->role->name == 'subsidiary_receiving_committee_president')->first();

        $subsidiary_receiving_committee_member = User::with('roles')->get()->filter(fn(
            $user
        ) => $user->office && $user->office->id == $office->id && $user->role->name == 'subsidiary_receiving_committee_member')->first();

        $supplier = User::with('roles')->get()->filter(fn(
            $user
        ) => $user->office && $user->office->id == $office->id && $user->role->name == 'supplier')->first();

        return view('employment.form-employment-print', compact(
            'import',
            'formEmployment',
            'titleAndCountsArr',
            'subsidiary_receiving_committee_president',
            'subsidiary_receiving_committee_member', 'supplier'
        ));
    }
}
