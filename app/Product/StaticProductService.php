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


        return $this->getSurplusData(
            $report,
            $meal,
            $surplusBenefitFromTypes,
            $surplusProductErrorAmount,
            $surplusProductErrorBenefits
        );
    }


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
        $totalAmountForMeal = $amountForMeal * $import->benefits;

        $thisDayImported = $amountForMeal && $this->staticProduct->importProductError
            ? $this->staticProduct->importProductError->error / $timesPerDay
            : 0;

        return [
            'amountForMeal' => $amountForMeal ?: 0,
            'totalAmountForMeal' => $totalAmountForMeal ?: 0,
            'thisDayImported' => $thisDayImported ?: 0,
        ];
    }

    public function getSurplusData(
        $report,
        $meal,
        $surplusBenefitFromTypes,
        $surplusProductErrorAmount,
        $surplusProductErrorBenefits
    ) {

        $importData = $this->calcImportedDataForMeal($report, $meal);

        $amountForMeal = $importData['amountForMeal'];
        $thisDayImported = $importData['thisDayImported'];

        $surplusBenefit = $surplusBenefitFromTypes + $surplusProductErrorBenefits;

        $totalSurplus = $amountForMeal * $surplusBenefit + $surplusProductErrorAmount;

        $totalSurplus = max($totalSurplus, 0);

        $total = max($thisDayImported - $totalSurplus, 0);

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
}
