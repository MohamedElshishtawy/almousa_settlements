<?php

namespace App\Report;

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\Employee;
use App\Models\Meal;
use App\Office\Office;
use App\Office\OfficeController;
use App\Office\OfficeMission;
use App\Product\ProductController;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{

    public function reports()
    {
        $offices = (new OfficeController())->getOfficesForUser();


        $days = (new ReportSurvice())->getDays($offices);

        return view('reports', compact('days'));

    }

    public function import($officeMission, $date)
    {
        $officeMission = OfficeMission::find($officeMission);

        $office = $officeMission->office;

        $products = (new ProductController())->getProducts($officeMission);

        return view('reports.import',
            compact('office', 'date', 'products', 'officeMission'));
    }

    public function importPrint($office, $date)
    {
        $office = is_object($office) ?: Office::find($office);
        $report = $office->reports()->where('for_date', $date)->first();
        $products = $report->staticProducts;

        $import = $report ? $report->import : null ;

        $date = Day::DateToHijri($date);

        return view('reports.import-to-print',
            compact('office', 'date', 'products', 'import'));
    }

    public function importPrintWriting($office, $date)
    {
        $office = is_object($office) ?: Office::find($office);
        $report = $office->reports()->where('for_date', $date)->first();
        $products = $report->staticProducts;

        $import = $report ? $report->import : null ;

        $Hijri = Day::DateToHijriSpecificArray($date);

        return view('reports.import-writing-print',
            compact('office', 'Hijri', 'products', 'report', 'import'));
    }



    public function surplus($officeMission, $date, $meal = null)
    {
        $officeMission = OfficeMission::find($officeMission);

        $office = $officeMission->office;

        $report = $office->reports()->where('for_date', $date)->first();


        $staticProducts = $report->staticProducts;

        $meals = Meal::getMealsFor($officeMission->mission);

        $urlMeal = $meal;
        return view('reports.surplus',
            compact('office', 'report', 'date', 'staticProducts', 'officeMission', 'meals', 'urlMeal'));
    }

    public function surplusPrint($officeMission, $date, $mealId)
    {

        $officeMission = OfficeMission::find($officeMission);
        $office = $officeMission->office;
        $report = $office->reports()->where('for_date', $date)->first();
        $staticProducts = $report->staticProducts;
        $surplus = $report->surplus->where('meal_id', $mealId)->first();
        $meal = Meal::find($mealId);
        return view('reports.surplus-to-print',
            compact('office', 'report', 'date', 'staticProducts', 'officeMission', 'surplus', 'meal'));

    }

}
