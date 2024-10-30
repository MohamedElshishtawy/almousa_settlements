<?php

namespace App\Livewire\Reports;

use App\Office\Office;
use App\Product\StaticProduct;
use App\Report\Report;
use Livewire\Component;

class Import extends Component
{
    public $report;
    public  $office, $date;
    public $benefits = 0;
    public $benefitError = 0;
    public $products;
    public $realyImported = []; // Array to hold each product’s supply error

    protected function setData() {
        $this->report = Report::where('office_id', $this->office->id)->where('for_date', $this->date)->first();
        // if report is null make null with the null attripute

        if ($this->report) {
            $this->benefits = $this->report->import->benefits;
            $this->benefitError = $this->report->import->benefits_error;
            $this->products = $this->report->staticProducts;
            $this->report->import->importProductError->each(function ($error) {
                $this->realyImported[$error->staticProduct->id] = $error->error;
            });
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
        $this->reset(['benefits', 'benefitError', 'realyImported']);
        $this->products = (new \App\Product\ProductQuery())->getProducts($this->office);
        $this->setData();
    }

    public function save()
    {
        // create Report
        $report = new \App\Report\Report();
        $report->office()->associate($this->office);
        $report->for_date = $this->date;
        $report->save();

        // create import
        $import = new \App\Report\Import();
        $import->report()->associate($report);
        $import->benefits = $this->benefits;
        $import->benefits_error = $this->benefitError;
        $import->save();

        // create static product assisged with product for this office mission and living
        foreach ($this->products as $product) {
            $staticProduct = StaticProduct::create([
                'old_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'daily_amount'  => $product->daily_amount,
                'food_type_id' => $product->food_type_id,
                'food_unit_id' => $product->food_unit_id,
                'report_id' => $report->id,
            ]);
            // put the days meals for this product

            foreach ($product->pdoductsDayMeal  as $dayMeal) {
                $staticProduct->pdoductsDayMeal()->create([
                    'day_id' => $dayMeal->day_id,
                    'meal_id' => $dayMeal->meal_id,
                ]);
            }

            if (isset($this->realyImported[$product->id])) {
                $importProductError = new \App\Report\ImportProductError();
                $importProductError->import()->associate($import);
                $importProductError->staticProduct()->associate($staticProduct);
                $importProductError->error = $this->realyImported[$product->id];
                $importProductError->save();
            }
        }





   }

    public function render()
    {
        return view('livewire.reports.import');
    }

    // Method to calculate the difference for a specific product
    public function calculateDifference($index, $expectedSupply)
    {
        $error = isset($this->realyImported[$index]) ? $this->realyImported[$index] : 0;
        $this->realyImported[$index] = $error;
        return $expectedSupply - $error;
    }
}
