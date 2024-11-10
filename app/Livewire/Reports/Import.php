<?php

namespace App\Livewire\Reports;

use App\Office\Office;
use App\Product\ProductController;
use App\Product\ProductDayMeal;
use App\Product\StaticProduct;
use App\Report\ImportProductError;
use App\Report\Report;
use Livewire\Component;

class Import extends Component
{
    public $report;
    public  $office, $date, $officeMission;
    public $benefits ;
    public $benefitError;
    public $products;
    public $reallyImported; // Array to hold each product’s supply error

    /*
     * To set data if there is an old Report saved
     * */
    protected function setData() {
        $this->report = Report::where('office_id', $this->office->id)->where('for_date', $this->date)->first();
        // if report is null make null with the null attripute

        if ($this->report) {
            $this->benefits = $this->report->import->benefits;
            $this->benefitError = $this->report->import->benefits_error;
            $this->products = $this->report->staticProducts;
            $this->report->import->importProductError->each(function ($error) {
                $this->reallyImported[$error->staticProduct->id] = $error->error;
            });
            foreach ($this->products as $staticProduct)  {
                if ($staticProduct->importProductError) {
                    $this->reallyImported[$staticProduct->id] = number_format((float)$staticProduct->importProductError->error,
                        2, '.', '');
                }
            }
        }
    }

    public function updatedBenefits()
    {
        foreach ($this->products as $product) {
            $productMissionData = $this->report ? $product : $product->productsLivingMission
                ->where('living_id', $this->office->living_id)
                ->where('mission_id', $this->officeMission->mission_id)
                ->first();

            //$this->benefitError =  $this->benefitError && is_numeric($this->benefitError) ? $this->benefitError : 0;

            if ($this->benefits && is_numeric($this->benefits)) {
                if ($this->report) {
                    $dailyTotal = StaticProduct::howMealPerDay($product->id, \App\Models\Day::date2object($this->date)->id) ;
                } else {
                    $dailyTotal = ProductDayMeal::howMealPerDay($productMissionData->id, \App\Models\Day::date2object($this->date)->id);
                }

                if ($dailyTotal) {
                    $this->reallyImported[$product->id] = number_format((float)$productMissionData->daily_amount * $this->benefits,
                        2, '.', '');
                }
            }


        }
    }

    public function mount()
    {
        if (!is_object($this->office)) {
            $this->office = \App\Office\Office::find($this->office);
        }

       $this->setData();
    }

    public function dateChanged()
    {
        $this->reset(['benefits', 'benefitError', 'reallyImported', 'report']);
        $this->reallyImported = [];

        $this->products =  (new ProductController())->getProducts($this->officeMission);
        $this->setData();
    }


    public function importedChanged($id, $value)
    {
        $index = $id;
        $rellyImported = isset($this->reallyImported[$index]) ? $this->reallyImported[$index] : 0;
        $this->reallyImported[$index] = (float)$value;

    }
    public function save()
    {

        if (!is_numeric($this->benefits) && $this->benefits <= 0) {
            return;
        }

        // if there is old report don't make
        if (Report::where('for_date')->where('office_id', $this->office->id)->exists()) {
            return; // update insted of this
        }

        // create Report
        $report = new Report();
        $report->office()->associate($this->office);
        $report->for_date = $this->date;
        $report->save();
        $this->report = $report;

        // create import
        $import = new \App\Report\Import();
        $import->report()->associate($report);
        $import->benefits = $this->benefits > 0  ? $this->benefits : 0;
        $import->benefits_error = is_numeric($this->benefitError) && $this->benefitError > 0 ? $this->benefitError : 0;
        $import->save();

        // create static product asssigned with product for this office mission and living
        foreach ($this->products as $product) {
            $productMissionData = $product->productsLivingMission
                ->where('living_id', $this->office->living_id)
                ->where('mission_id', $this->officeMission->mission_id)
                ->first();
            $staticProduct = StaticProduct::create([
                'old_id' => $product->id,
                'old_product_living_mission_old' => $productMissionData->id,
                'name' => $product->name,
                'price' => $productMissionData->price,
                'daily_amount'  => $productMissionData->daily_amount,
                'food_type_id' => $product->food_type_id,
                'food_unit_id' => $product->food_unit_id,
                'report_id' => $report->id,
            ]);
            // put the days meals for this product

            foreach ($productMissionData->productsDayMeal  as $dayMeal) {
                $staticProduct->productsDayMeal()->create([
                    'day_id' => $dayMeal->day_id,
                    'meal_id' => $dayMeal->meal_id,
                ]);
            }

            if (isset($this->reallyImported[$product->id])) {
                $importProductError = new \App\Report\ImportProductError();
                $importProductError->import()->associate($import);
                $importProductError->staticProduct()->associate($staticProduct);
                $importProductError->error = is_numeric($this->reallyImported[$product->id]) ? $this->reallyImported[$product->id] : 0;
                $importProductError->save();
            }

        }
        return redirect()->route('managers.reports.import', [$this->officeMission->id , $this->date])->with('success', 'تم الحفظ بنجاح;');
   }

    public function reportUpdate()
    {

        $import = $this->report->import;
        $import->benefits = $this->benefits;
        $import->benefits_error = $this->benefitError;
        $import->save();

        // create static product asssigned with product for this office mission and living
        foreach ($this->products as $staticProduct) {
            if($staticProduct->importProductError) {
                $staticProduct->importProductError->delete();
            }
            if (isset($this->reallyImported[$staticProduct->id])) {
                ImportProductError::create([
                    'static_product_id' => $staticProduct->id,
                    'import_id' => $import->id,
                    'error' => $this->reallyImported[$staticProduct->id],
                ]);
            }
        }
        return redirect()->route('managers.reports.import', [$this->officeMission->id, $this->date])->with('success', 'تم الحفظ بنجاح;');
    }
    public function render()
    {
        return view('livewire.reports.import', [
            'products' => $this->products
        ]);
    }

    // Method to calculate the difference for a specific product
    public function calculateDifference($index, $expectedSupply)
    {
        $rellyImported = isset($this->reallyImported[$index]) ? $this->reallyImported[$index] : 0;

        $this->reallyImported[$index] = $rellyImported;
        return $expectedSupply - $rellyImported;
    }
}
