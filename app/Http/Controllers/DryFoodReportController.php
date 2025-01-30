<?php

namespace App\Http\Controllers;

use App\Models\DryFoodReport;
use App\Models\HijriDate;
use App\Office\Office;
use App\Product\ProductLivingMission;

class DryFoodReportController extends Controller
{
    public function index()
    {
        $dryFoodReports = DryFoodReport::all();

        return view('dry-food-reports.index', compact('dryFoodReports'));
    }

    public function create()
    {
        return view('dry-food-reports.create');
    }

    public function edit($dryFoodReport)
    {
        $dryFoodReport = DryFoodReport::find($dryFoodReport);
        if (!$dryFoodReport) {
            return redirect()->route('dry-food-reports.create');
        }
        return view('dry-food-reports.edit', compact('dryFoodReport'));
    }

    public function print($dryFoodReport)
    {
        $dryFoodReport = DryFoodReport::find($dryFoodReport);

        if (!$dryFoodReport) {
            return redirect()->route('dry-food-reports.create');
        }

        $office = Office::find($dryFoodReport->delegate->office_id);
        $productMissionLivings = ProductLivingMission::where('living_id', $office->living_id)
            ->where('mission_id', $dryFoodReport->mission_id)->get();
        $products = $productMissionLivings->map(fn($productMissionLiving) => $productMissionLiving->product);
        // filter only products that have both carton and packet values
        $products = $products->filter(function ($product) {
            return $product->carton_value && $product->packet_value;
        });
        return view('dry-food-reports.print', compact('dryFoodReport', 'products'));
    }

    public function delegateReport($dryFoodReport)
    {
        $dryFoodReport = DryFoodReport::find($dryFoodReport);
        $delegate = $dryFoodReport->delegate;
        $formatedDate = HijriDate::formatedDate($dryFoodReport->created_at->format('Y-m-d'));


        return view('dry-food-reports.report-for-delegater', compact('dryFoodReport', 'formatedDate', 'delegate'));

    }

    public function delete(DryFoodReport $dryFoodReport)
    {
        $dryFoodReport->delete();
        return redirect()->route('dry-food-reports');
    }


}
