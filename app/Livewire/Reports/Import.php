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
    public $office, $date, $officeMission;
    public $benefits;
    public $benefitError = 0;
    public $products;
    public $reallyImported = []; // Holds each product’s imported supply data

    // rules for validation
    protected function rules()
    {
        return [
            'benefits' => 'required|numeric|min:1',
            'benefitError' => 'numeric|min:0',
            'date' => 'required|date',
        ];
    }

    public function updatedBenefits()
    {
        foreach ($this->products as $product) {
            $dailyTotal = $this->report ? StaticProduct::howMealPerDay($product->id,
                \App\Models\Day::date2object($this->date)->id) :
                ProductDayMeal::howMealPerDay($product->id, \App\Models\Day::date2object($this->date)->id);
            if ($dailyTotal && is_numeric($this->benefits)) {
                $this->reallyImported[$product->id] = round($product->daily_amount * $this->benefits, 4);
            }
        }
    }

    public function mount()
    {
        $this->office = is_object($this->office) ? $this->office : Office::find($this->office);
        $this->setData();
    }

    protected function setData()
    {
        $this->report = Report::with(['import', 'staticProducts.importProductError'])
            ->where('office_id', $this->office->id)
            ->where('for_date', $this->date)
            ->first();

        if ($this->report) {
            $this->benefits = $this->report->import->benefits ?? 0;
            $this->benefitError = $this->report->import->benefits_error ?? 0;
            $this->products = $this->report->staticProducts;

            foreach ($this->products as $product) {
                $this->reallyImported[$product->id] = isset($product->importProductError) ?
                    round($product->importProductError->error, 4) : 0;
            }
        } else {
            // reset
            $this->benefits = null;
            $this->benefitError = 0;
            $this->products = (new ProductController())->getProducts($this->officeMission);
        }
    }

    public function dateChanged()
    {
        $this->reset(['benefits', 'benefitError', 'reallyImported', 'report']);
        $this->products = (new ProductController())->getProducts($this->officeMission);
        $this->setData();
    }

    public function importedChanged($id, $value)
    {
        $this->reallyImported[$id] = (float) $value;
    }

    public function benefitChanged($value)
    {
        // edit the reallyImported array
        foreach ($this->products as $product) {
            $productMissionData = $this->report ? $product : \App\Product\Product::getProductMissionData($product,
                $this->office, $this->officeMission);

            $dailyTotal = $this->report ? \App\Product\StaticProduct::howMealPerDay($product->id,
                \App\Models\Day::date2object($this->date)->id) :
                \App\Product\ProductDayMeal::howMealPerDay($productMissionData->id,
                    \App\Models\Day::date2object($this->date)->id);

            if ($dailyTotal && is_numeric($value)) {
                $this->reallyImported[$product->id] = round($productMissionData->daily_amount * $value, 4);
            }
        }
    }

    public function reportUpdate()
    {
        $import = $this->report->import;
        $import->benefits = $this->benefits;
        $import->benefits_error = $this->benefitError;
        $import->save();

        // create static product asssigned with product for this office mission and living
        foreach ($this->products as $staticProduct) {
            if ($staticProduct->importProductError) {
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

        activity('import')->causedBy(auth()->user())->performedOn($import)->withProperties([
            'office' => $this->office->name,
            'date' => $this->date,
            'import' => $import->id,
        ])->log('تم تحديث المحضر توريد');

        session()->flash('success', 'تم تحديث المحضر بنجاح.');
        return redirect()->route('managers.reports.import', [$this->officeMission->id, $this->date]);
    }

    public function save()
    {
        // Check if benefits is a valid number, greater than 0, and that no report exists for the date and office
        $this->validate();

        // Create the report for the specified office and date
        $report = Report::create([
            'office_id' => $this->office->id,
            'for_date' => $this->date,
        ]);

        // Create the import entry for the report
        $import = $report->import()->create([
            'benefits' => $this->benefits,
            'benefits_error' => $this->benefitError,
        ]);

        // Loop through each product and add it to staticProducts as related records
        foreach ($this->products as $product) {
            $productMissionData = $product->productsLivingMission
                ->where('living_id', $this->office->living_id)
                ->where('mission_id', $this->officeMission->mission_id)
                ->first();

            $staticProduct = $report->staticProducts()->create([
                'old_id' => $product->id,
                'old_product_living_mission_old' => $productMissionData->id,
                'name' => $product->name,
                'price' => $productMissionData->price,
                'daily_amount' => $productMissionData->daily_amount,
                'food_type_id' => $product->food_type_id,
                'food_unit_id' => $product->food_unit_id,
                'report_id' => $report->id,
                'carton_value' => $product->carton_value,
                'packet_value' => $product->packet_value,
            ]);

            // put the days meals for this product
            foreach ($productMissionData->productsDayMeal as $dayMeal) {
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

        activity('import')->causedBy(auth()->user())->performedOn($import)->withProperties([
            'office' => $this->office->name,
            'date' => $this->date,
            'import' => $import->id,
        ])->log('تم إضافة محضر توريد');

        session()->flash('success', 'تم إضافة المحضر. يتم توجيهك لتقيم العمالة..');

        sleep(2);

        session()->forget('success');

        return redirect()->route('managers.employment', ['import' => $import->id]);
    }

    public function delete()
    {
        $import = $this->report->import;
        $this->report->delete();

        activity('import')->causedBy(auth()->user())->performedOn($import)->withProperties([
            'office' => $this->office->name,
            'date' => $this->date,
            'import' => $import->id,
        ])->log('تم حذف تقرير توريد');

        $this->reset(['benefits', 'benefitError', 'reallyImported', 'report']);
        $this->setData();
        session()->flash('success', 'تم الحذف بنجاح.');
    }

    public function render()
    {
        return view('livewire.reports.import');
    }
}
