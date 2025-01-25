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
        $titles = $formEmploymentElements->pluck('title')->toArray();
        $ealCounts = $formEmploymentElements->pluck('count', 'id')->toArray();
        $counts = [];
        foreach ($ealCounts as $id => $realCount) {
            $counts[$id]['real'] = $realCount;
            $formEmploymentElement = $formEmploymentElements->where('id', $id)->first();
            $counts[$id]['expected'] = $formEmploymentElement
                ->getEmploymentRealCount($formEmploymentElement->benefits,
                    $formEmploymentElement->main_count,$import->getBenefits());
        }
        return view('employment.form-employment-print', compact(
            'import',
            'formEmployment',
            'titles',
            'counts',
        ));

    }
}
