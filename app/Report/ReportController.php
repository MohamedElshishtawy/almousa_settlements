<?php

namespace App\Report;

use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\Meal;
use App\Office\Office;
use App\Office\OfficeController;
use App\Office\OfficeMission;
use App\Product\ProductController;

class ReportController extends Controller
{

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

        $import = $report ? $report->import : null;

        $dateHijry = Day::DateToHijri($date);

        return view('reports.import-to-print',
            compact('office', 'date', 'dateHijry', 'products', 'import'));
    }

    public function reports()
    {
        $offices = (new OfficeController())->getOfficesForUser();


        $days = (new ReportSurvice())->getDays($offices);

        return view('reports', compact('days'));

    }

    public function importPrintWriting($office, $date)
    {
        $office = is_object($office) ?: Office::find($office);
        $report = $office->reports()->where('for_date', $date)->first();
        $products = $report->staticProducts;

        $import = $report ? $report->import : null;

        $isHasDifferance = $report->import->isDiffrence();

        $Hijri = Day::DateToHijriSpecificArray($date);


        return view('reports.import-writing-print',
            compact('office', 'Hijri', 'products', 'report', 'import', 'isHasDifferance'));
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

    public function surplusPrint($officeMission, $date, $mealId = null)
    {

        $officeMission = OfficeMission::find($officeMission);
        $office = $officeMission->office;
        $report = $office->reports()->where('for_date', $date)->first();
        $staticProducts = $report->staticProducts;
        // if there is no meal id will print for all available meals for this report's surplus
        if ($mealId) {
            $meal = Meal::find($mealId);
            $surplus = $report->surplus->where('meal_id', $mealId)->first();
        } else {
            $meal = null;
            $surplus = null;
        }
        return view('reports.surplus-to-print',
            compact('office', 'report', 'date', 'staticProducts', 'officeMission', 'surplus', 'meal'));

    }

    public function AnalyticsImport($showPrices = null)
    {
        return view('analytics.import-analytics', compact('showPrices'));
    }

    public function AnalyticsSurplus($showPrices = null)
    {
        return view('analytics.surplus-analytics', compact('showPrices'));
    }


    public function AnalyticsBenefits()
    {
        return view('analytics.benefits-analytics');
    }
}
