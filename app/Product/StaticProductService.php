<?php

namespace App\Product;

use App\Models\Day;
use App\Models\Meal;
use App\Report\Report;

class StaticProductService
{
    protected $staticProduct;

    public function __construct(StaticProduct $staticProduct)
    {
        $this->staticProduct = $staticProduct;
    }

    public function getHowManyDayPerWeekUsed($id, $fromStatic = false)
    {
        return $this->staticProduct->productsDayMeal()->select('day_id')->groupBy('day_id')->get()->count();
    }


    public function getSurplusDataFor(Report $report, Meal $meal)
    {
        // from database | if you want for calc use getSurplusData() direct
        // surplus for the meal only
        $surplus = $report->surplus->where('meal_id', $meal->id)->first();

        $surplusBenefitFromTypes = $surplus->surplusFoodTypes
            ->where('food_type_id', $this->staticProduct->food_type_id)->first()->value ?? 0;
        $surplusProductError = $surplus->surplusProductErrors
            ->where('static_product_id', $this->staticProduct->id)->first();

        $surplusProductErrorBenefits = $surplusProductError ? $surplusProductError->surplus_benefits : 0;
        $surplusProductErrorAmount = $surplusProductError ? $surplusProductError->surplus_amount : 0;


        return $this->calcSurplusData(
            $report,
            $meal,
            $surplusBenefitFromTypes,
            $surplusProductErrorAmount,
            $surplusProductErrorBenefits
        );
    }

//    public function getSurplusDataForAllMeals(
//        Report $report,
//        Meal $meal
//    ) // temporary // if you solved the error ratio in the small numbers
//    {
//        $surplus = $report->surplus->where('meal_id', $meal->id)->first();
//
//        $surplusBenefitFromTypes = $surplus->surplusFoodTypes
//            ->where('food_type_id', $this->staticProduct->food_type_id)->first()->value ?? 0;
//        $surplusProductError = $surplus->surplusProductErrors
//            ->where('static_product_id', $this->staticProduct->id)->first();
//
//        $surplusProductErrorBenefits = $surplusProductError ? $surplusProductError->surplus_benefits : 0;
//        $surplusProductErrorAmount = $surplusProductError ? $surplusProductError->surplus_amount : 0;
//
//
//        return $this->calcSurplusDataForAllMeals(
//            $report,
//            $meal,
//            $surplusBenefitFromTypes,
//            $surplusProductErrorAmount,
//            $surplusProductErrorBenefits
//        );
//    }


    public function calcImportedDataForMeal(Report $report, Meal $meal)
    {
        $import = $report->import;
        $day = Day::date2object($report->for_date);

        $productLivingMission = \App\Product\ProductLivingMission::where('product_id', $this->staticProduct->old_id)
            ->where('living_id', $report->office->living_id)
            ->where('mission_id', $report->office->getOfficeMission($report->for_date)->mission_id)
            ->first();

        $timesPerDay = $this->staticProduct->getHowManyPerDay($day);
        $amountForMeal = $this->staticProduct->getAmountForMeal($day, $meal, $productLivingMission);
        $totalAmountForMeal = bcmul($amountForMeal, $import->benefits, 100);

        $thisDayImported = $amountForMeal && $this->staticProduct->importProductError
            ? bcdiv($this->staticProduct->importProductError->imported_amount, $timesPerDay, 100)
            : 0;

        return [
            'daily_amount' => $this->staticProduct->daily_amount,
            'amountForMeal' => $amountForMeal ?: 0,
            'totalAmountForMeal' => $totalAmountForMeal ?: 0,
            'thisDayImported' => $thisDayImported ?: 0,
        ];
    }

    public function calcSurplusData(
        $report,
        $meal,
        $surplusBenefitFromTypes,
        $surplusProductErrorAmount,
        $surplusProductErrorBenefits
    ) {

        $importData = $this->calcImportedDataForMeal($report, $meal);

        $amountForMeal = $importData['amountForMeal'];
        $thisDayImported = $importData['thisDayImported'];

        $surplusBenefit = bcadd($surplusBenefitFromTypes, $surplusProductErrorBenefits, 100);

        $totalSurplus = bcadd(bcmul($amountForMeal, $surplusBenefit, 100), $surplusProductErrorAmount, 100);

        $totalSurplus = max($totalSurplus, 0);


        $total = bcsub($thisDayImported, $totalSurplus, 100);


        $total = max($total, 0);

        return [
            'amountForMeal' => $amountForMeal,
            'totalAmountForMeal' => $importData['totalAmountForMeal'],
            'thisDayImported' => $thisDayImported,
            'surplusProductError' => $surplusProductErrorAmount,
            'surplusBenefitFromTypes' => $surplusBenefitFromTypes,
            'surplusBenefit' => $surplusBenefit,
            'totalSurplus' => $totalSurplus,
            'total' => $total
        ];

    }

//    public function calcSurplusDataForAllMeals( // temporary
//        $report,
//        $meal,
//        $surplusBenefitFromTypes,
//        $surplusProductErrorAmount,
//        $surplusProductErrorBenefits
//    ) {
//
//        $importData = $this->calcImportedDataForMeal($report, $meal);
//
//        $amountForMeal = $importData['daily_amount'];
//        $thisDayImported = $importData['thisDayImported'];
//
//        $surplusBenefit = $surplusBenefitFromTypes + $surplusProductErrorBenefits;
//
//        $totalSurplus = $importData['amountForMeal'] * $surplusBenefit + $surplusProductErrorAmount;
//
//        $totalSurplus = max($totalSurplus, 0);
//
//        $total = max($thisDayImported - $totalSurplus, 0);
//
//        return [
//            'amountForMeal' => $importData['daily_amount'],
//            'totalAmountForMeal' => $importData['daily_amount'] * $report->import->benefits,
//            'thisDayImported' => round($thisDayImported, 4),
//            'surplusProductError' => round($surplusProductErrorAmount, 4),
//            'surplusBenefitFromTypes' => round($surplusBenefitFromTypes, 4),
//            'surplusBenefit' => round($surplusBenefit, 4),
//            'totalSurplus' => round($totalSurplus, 4),
//            'total' => round($total, 4)
//        ];
//
//    }
}
