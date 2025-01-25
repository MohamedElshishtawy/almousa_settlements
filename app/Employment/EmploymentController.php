<?php

namespace App\Employment;

use App\Http\Controllers\Controller;
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

        return view('employment.form-employment-print', compact(
            'import',
            'formEmployment',
            'titleAndCountsArr'
        ));
    }
}
