<?php

namespace App\Livewire\Reports;

use App\Models\Meal;
use App\Product\FoodType;
use App\Report\SurplusFoodType;
use App\Report\SurplusProductError;
use Livewire\Component;

class Surplus extends Component
{
    public $report, $surplus;
    public $office, $date, $officeMission;
    public $surplusAmount = [], $surplusBenefits = [], $surplusfoodTypeValues = [];
    public $staticProducts;

    public $urlMeal, $meals, $selectedMeal, $sameReportMeals = [];

    public function mount()
    {
        if (!$this->selectedMeal) {
            $this->selectedMeal = $this->meals->first();
        }
        if ($this->urlMeal) {
            $this->selectedMeal = Meal::find($this->urlMeal);
        }


        if (!is_object($this->office)) {
            $this->office = \App\Office\Office::find($this->office);
        }
        $surpluses = $this->report->surplus;
        if ($surpluses->count() > 0) {
            $this->surplus = $surpluses->where('meal_id', $this->selectedMeal->id)->first();
            if (!$this->surplus && !$this->urlMeal) {
                $this->surplus = $surpluses->first();
                $this->selectedMeal = Meal::find($this->surplus->meal_id);
            }

            $this->setData();


        }

    }

    public function setData()
    {
        if (!$this->surplus) {
            // reset arrays and data
            $this->surplusAmount = [];
            $this->surplusBenefits = [];
            $this->surplusfoodTypeValues = [];
            return;
        }
        // put all the arrays data for the database
        foreach ($this->surplus->surplusProductErrors ?? [] as $surplusProductError) {
            $this->surplusAmount[$surplusProductError->static_product_id] = $surplusProductError->surplus_amount;
            $this->surplusBenefits[$surplusProductError->static_product_id] = $surplusProductError->surplus_benefits;
        }
        foreach ($this->surplus->surplusFoodTypes as $surplusFoodType) {
            $this->surplusfoodTypeValues[$surplusFoodType->food_type_id] = $surplusFoodType->value;
        }
    }

    public function surplusAmountUpdate($staticProductId, $value)
    {
        $this->surplusAmount[$staticProductId] = $value && is_numeric($value) ? $value : 0;
    }

    public function surplusBenefitsUpdate($staticProductId, $value)
    {

        $this->surplusBenefits[$staticProductId] = $value && is_numeric($value) ? $value : 0;

    }

    public function FoodTypeValuesUpdate($foodTypeId, $value)
    {
//        if ($value > $this->report->import->benefits) {
//            $value = $this->report->import->benefits;
//        }
        $this->surplusfoodTypeValues[$foodTypeId] = $value && is_numeric($value) ? $value : 0;
        $this->staticProducts = $this->staticProducts;
    }

    public function sameReportMealsChanged($mealId)
    {
        if (in_array($mealId, $this->sameReportMeals)) {
            $this->sameReportMeals = array_diff($this->sameReportMeals, [$mealId]);
        } else {
            $this->sameReportMeals[] = $mealId;
        }
    }

    public function reportUpdate()
    {
        $surplus = $this->surplus;

        foreach (FoodType::all() as $foodType) {
            // create or update the surplusFoodType if there is a change
            $surplusFoodType = $surplus->surplusFoodTypes->where('food_type_id', $foodType->id)->first();
            if (!$surplusFoodType) {
                $surplusFoodType = new SurplusFoodType();
                $surplusFoodType->surplus_id = $surplus->id;
                $surplusFoodType->food_type_id = $foodType->id;
                $surplusFoodType->value = $this->surplusfoodTypeValues[$foodType->id] ?? 0;
                $surplusFoodType->save();
            } else {
                if ($surplusFoodType->value != $this->surplusfoodTypeValues[$foodType->id]) {
                    $surplusFoodType->value = $this->surplusfoodTypeValues[$foodType->id] ?? 0;
                    $surplusFoodType->save();
                }
            }
            // create or update if there is a change
            foreach ($this->staticProducts as $staticProduct) {
                $surplusProductError = $surplus->surplusProductErrors ? $surplus->surplusProductErrors->where('static_product_id',
                    $staticProduct->id)->first() : null;
                if (!$surplusProductError) {
                    $surplusProductError = new SurplusProductError();
                    $surplusProductError->surplus_id = $surplus->id;
                    $surplusProductError->static_product_id = $staticProduct->id;
                    $surplusProductError->surplus_benefits = $this->surplusBenefits[$staticProduct->id] ?? 0;
                    $surplusProductError->surplus_amount = $this->surplusAmount[$staticProduct->id] ?? 0;
                    $surplusProductError->save();
                } else {
                    if ($surplusProductError->surplus_benefits != $this->surplusBenefits[$staticProduct->id]) {
                        $surplusProductError->surplus_benefits = $this->surplusBenefits[$staticProduct->id] ?? 0;
                        $surplusProductError->save();
                    }
                    if ($surplusProductError->surplus_amount != $this->surplusAmount[$staticProduct->id]) {
                        $surplusProductError->surplus_amount = $this->surplusAmount[$staticProduct->id] ?? 0;
                        $surplusProductError->save();
                    }
                }
            }
        }
        return redirect()->route('managers.reports.surplus',
            [$this->officeMission->id, $this->date, $this->selectedMeal])->with('success', 'تم الحفظ بنجاح;');
    }

    public function save($forMeal = null)
    {
        if (!$forMeal) {
            $forMeal = $this->selectedMeal;
        }

        // create Report
        $surplus = new \App\Report\Surplus();
        $surplus->report_id = $this->report->id;
        $surplus->meal_id = $forMeal->id;
        $surplus->save();

        foreach (FoodType::all() as $foodType) {
            $surplusFoodType = new SurplusFoodType();
            $surplusFoodType->surplus_id = $surplus->id;
            $surplusFoodType->food_type_id = $foodType->id;
            $surplusFoodType->value = $this->surplusfoodTypeValues[$foodType->id] ?? 0;
            $surplusFoodType->save();

            foreach ($this->staticProducts as $staticProduct) {
                if (isset($this->surplusAmount[$staticProduct->id]) || isset($this->surplusBenefits[$staticProduct->id])) {
                    $surplusProductError = new \App\Report\SurplusProductError();
                    $surplusProductError->surplus_id = $surplus->id;
                    $surplusProductError->static_product_id = $staticProduct->id;
                    $surplusProductError->surplus_benefits = $this->surplusBenefits[$staticProduct->id] ?? 0;
                    $surplusProductError->surplus_amount = $this->surplusAmount[$staticProduct->id] ?? 0;
                    $surplusProductError->save();
                }
            }
        }
        if ($this->sameReportMeals) {
            $this->save(Meal::find(array_pop($this->sameReportMeals)));
        }

        return redirect()->route('managers.reports.surplus',
            [$this->officeMission->id, $this->date, $this->selectedMeal])->with('success', 'تم الحفظ بنجاح;');
    }

    public function changeMeal($mealId)
    {
        $this->selectedMeal = Meal::find($mealId);
        $surpluses = $this->report->surplus;
        if ($surpluses) {
            $this->surplus = $surpluses->where('meal_id', $this->selectedMeal->id)->first();

            $this->setData();
        }

    }

    public function delete()
    {
        if ($this->surplus) {
            $this->surplus->delete();
            return redirect()->route('managers.reports.surplus',
                [$this->officeMission->id, $this->date, $this->selectedMeal])->with('success', 'تم الحذف بنجاح;');
        }

    }

    public function render()
    {
        return view('livewire.reports.surplus');
    }
}
