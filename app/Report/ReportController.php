<?php

namespace App\Report;

use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\Meal;
use App\Models\User;
use App\Office\Office;
use App\Office\OfficeController;
use App\Office\OfficeMission;
use App\Product\ProductController;
use App\Product\StaticProductService;

class ReportController extends Controller
{

    // The page for showing the reports
    public function reports()
    {
        $offices = (new OfficeController())->getOfficesForUser();

        $days = (new ReportSurvice())->getDays($offices);

        $officesReports = (new ReportSurvice())->days2groupOffices($days);
//        dd(auth()->user()->can('import_create'));
        return view('reports', compact('officesReports'));

    }

    // The page for creating or editing or printing import
    public function import($officeMission, $date)
    {
        $officeMission = OfficeMission::find($officeMission);

        $office = $officeMission->office;

        auth()->user()->AuthorizeOffice($office->id);

        $products = (new ProductController())->getProducts($officeMission);


        return view('reports.import',
            compact('office', 'date', 'products', 'officeMission'));
    }

    public function importPrint($office, $date)
    {
        $office = is_object($office) ?: Office::find($office);
        auth()->user()->AuthorizeOffice($office->id);
        $report = $office->reports()->where('for_date', $date)->first();
        $products = $report->staticProducts;

        $import = $report ? $report->import : null;

        $dateHijry = Day::DateToHijri($date);

        $subsidiary_receiving_committee_president = User::with('roles')->get()->filter(fn(
            $user
        ) => $user->office && $user->office->id == $office->id && $user->role->name == 'subsidiary_receiving_committee_president')->first();

        $subsidiary_receiving_committee_member = User::with('roles')->get()->filter(fn(
            $user
        ) => $user->office && $user->office->id == $office->id && $user->role->name == 'subsidiary_receiving_committee_member')->values();

        $supplier = User::with('roles')->get()->filter(fn(
            $user
        ) => $user->office && $user->office->id == $office->id && $user->role->name == 'supplier')->first();

        return view('reports.import-to-print',
            compact('office', 'date', 'dateHijry', 'products', 'import', 'subsidiary_receiving_committee_president',
                'subsidiary_receiving_committee_member', 'supplier'));
    }


    public function importPrintWriting($office, $date)
    {
        $office = is_object($office) ?: Office::find($office);
        $report = $office->reports()->where('for_date', $date)->first();
        $products = $report->staticProducts;

        $import = $report ? $report->import : null;

        $isHasDifferance = $report->import->isDiffrence();

        $Hijri = Day::DateToHijriSpecificArray($date);


        // Signs data
        $subsidiary_receiving_committee_president = User::with('roles')->get()->filter(fn(
            $user
        ) => $user->office && $user->office->id == $office->id && $user->role->name == 'subsidiary_receiving_committee_president')->first();

        $subsidiary_receiving_committee_member = User::with('roles')->get()->filter(fn(
            $user
        ) => $user->office && $user->office->id == $office->id && $user->role->name == 'subsidiary_receiving_committee_member')->values();

        $supplier = User::with('roles')->get()->filter(fn(
            $user
        ) => $user->office && $user->office->id == $office->id && $user->role->name == 'supplier')->first();


        return view('reports.import-writing-print',
            compact('office', 'Hijri', 'products', 'report', 'import', 'isHasDifferance',
                'subsidiary_receiving_committee_president',
                'subsidiary_receiving_committee_member', 'supplier'));
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
        $surplusData = [];
        $meal = null;

        $report = $office->reports()->where('for_date', $date)->first();
        $staticProducts = $report->staticProducts;
        // if there is no meal id will print for all available meals for this report's surplus
        if ($mealId) {
            $meal = Meal::find($mealId);
            $surplus = $report->surplus->where('meal_id', $mealId)->first();
            $surplusService = new SurplusService($surplus);
            foreach ($staticProducts as $staticProduct) {
                $staticProductService = new StaticProductService($staticProduct);
                $surplusData = $staticProductService->getSurplusDataFor($report, $meal);
                $staticProduct->surplusData = $surplusData;
            }

        } else {
            foreach ($report->surplus as $surplus) {
                $surplusMeal = $surplus->meal;
                foreach ($staticProducts as $staticProduct) {
                    $staticProductService = new StaticProductService($staticProduct);
                    $surplusData = $staticProductService->getSurplusDataFor($report, $surplusMeal);

                    if (!$staticProduct->surplusData) {
                        $staticProduct->surplusData = $surplusData;

                    } else {
                        $data = $staticProduct->surplusData;

                        $data['amountForMeal'] = bcadd($surplusData['amountForMeal'], $data['amountForMeal'], 100);
                        $data['totalAmountForMeal'] = bcadd($surplusData['totalAmountForMeal'],
                            $data['totalAmountForMeal'], 100);
                        $data['thisDayImported'] = bcadd($surplusData['thisDayImported'], $data['thisDayImported'],
                            100);
                        $data['surplusBenefit'] = $surplusData['surplusBenefit'] + $data['surplusBenefit'];
                        $data['totalSurplus'] = bcadd($surplusData['totalSurplus'], $data['totalSurplus'], 100);
                        $data['total'] = bcadd($surplusData['total'], $data['total'], 100);

                        $staticProduct->surplusData = $data;
                    }
                }
            }
        }


        // Signs data
        $subsidiary_receiving_committee_president = User::with('roles')->get()->filter(fn(
            $user
        ) => $user->office && $user->office->id == $office->id && $user->role->name == 'subsidiary_receiving_committee_president')->first();

        $subsidiary_receiving_committee_member = User::with('roles')->get()->filter(fn(
            $user
        ) => $user->office && $user->office->id == $office->id && $user->role->name == 'subsidiary_receiving_committee_member')->values();


        $supplier = User::with('roles')->get()->filter(fn(
            $user
        ) => $user->office && $user->office->id == $office->id && $user->role->name == 'supplier')->first();


        return view('reports.surplus-to-print',
            compact('office', 'report', 'date', 'staticProducts', 'officeMission', 'surplus', 'meal',
                'subsidiary_receiving_committee_president',
                'subsidiary_receiving_committee_member', 'supplier', 'surplusData'));

    }

    public function AnalyticsImport($showPrices = null)
    {
        if (!auth()->user()->role->hasPermissionTo('import_model2_create_price')) {
            $showPrices = null;
        }
        return view('analytics.import-analytics', compact('showPrices'));
    }

    public function AnalyticsSurplus($showPrices = null)
    {
        if (!auth()->user()->role->hasPermissionTo('import_model2_create_price')) {
            $showPrices = null;
        }


        return view('analytics.surplus-analytics', compact('showPrices'));
    }


    public function AnalyticsBenefits()
    {
        return view('analytics.benefits-analytics');
    }
}
