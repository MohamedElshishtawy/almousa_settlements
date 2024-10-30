<?php

namespace App\Report;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Office\Office;
use App\Office\OfficeController;
use App\Product\ProductController;

class ReportController extends Controller
{

    public function reports()
    {
        $offices = (new OfficeController())->getOfficesForUser();


        $days = (new ReportSurvice())->getDays($offices);

        return view('reports', compact('days'));

    }

    public function import($office, $date)
    {
        $products = (new ProductController())->getProducts($office);
        return view('reports.import',
            compact('office', 'date', 'products'));
    }

    public function importPrint($office, $date)
    {
        $office = is_object($office) ?: Office::find($office);
        $report = $office->reports()->where('for_date', $date)->first();
        $products = $report->staticProducts;

        $import = $report ? $report->import : null ;

        return view('reports.import-to-print',
            compact('office', 'date', 'products', 'import'));
    }


}
