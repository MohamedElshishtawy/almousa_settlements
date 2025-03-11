<?php

namespace App\Product;

use App\Models\Day;
use App\Models\Meal;
use App\Report\Report;
use http\Exception\InvalidArgumentException;

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

    public function getAllSurplus()
    {
        $totalSurplus = 0;
        $day = Day::date2object($this->staticProduct->report->for_date);

        foreach ($this->staticProduct->report->surplus as $surplus) {
            $meal = $surplus->meal;
            $productLivingMission = \App\Product\ProductLivingMission::where('product_id', $this->staticProduct->old_id)
                ->where('living_id', $surplus->report->office->living_id)
                ->where('mission_id',
                    $surplus->report->office->getOfficeMission($surplus->report->for_date)->mission_id)
                ->first();

            $amountForMeal = $this->staticProduct->getAmountForMeal($day, $meal, $productLivingMission);

            if (!$amountForMeal) {
                continue;
            }

            $mealPerDay = $this->staticProduct->getHowManyPerDay(Day::date2object($surplus->report->for_date));
            $surplusFromType = $surplus->surplusFoodTypes->where('food_type_id',
                $this->staticProduct->food_type_id)->first();
            $surplusFromTypeValue = $mealPerDay ? bcmul(optional($surplusFromType)->value,
                bcdiv($this->staticProduct->daily_amount, $mealPerDay, 100), 100) : 0;
            $surplusFromSpecific = $surplus->surplusProductErrors->where('static_product_id',
                $this->staticProduct->id)->first();
            $surplusFromSpecificValue = $surplusFromSpecific ? bcadd($surplusFromSpecific->surplus_amount,
                bcmul($surplusFromSpecific->surplus_benefits,
                    bcdiv($this->staticProduct->daily_amount, $mealPerDay, 100), 100),
                100) : 0;
            $totalSurplus = bcadd($totalSurplus, bcadd($surplusFromTypeValue, $surplusFromSpecificValue, 100), 100);
        }

        return $totalSurplus;
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
        $totalAmountForMeal = bcmul($amountForMeal, $import->benefits, 100);

        $thisDayImported = $amountForMeal && $this->staticProduct->importProductError
            ? bcdiv($this->staticProduct->importProductError->error, $timesPerDay, 100)
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


        $surplusBenefit = $importData['amountForMeal'] ? $surplusBenefitFromTypes : 0 + $surplusProductErrorBenefits;

        // execution error if there is no amount of data and there are some surplus
        if (!$importData['amountForMeal'] && $surplusBenefitFromTypes || $surplusProductErrorBenefits) {
            throw new InvalidArgumentException('لا يوجد توريد للمنتج وهناك وفر الرجاء الرجوع لأدمن الموقع');
        }

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
}
