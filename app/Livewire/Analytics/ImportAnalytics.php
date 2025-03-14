<?php

namespace App\Livewire\Analytics;

use App\Office\Office;
use App\Office\OfficeController;
use App\Report\ReportSurvice;
use Carbon\Carbon;
use Livewire\Component;

class ImportAnalytics extends Component
{
    public Office $office;
    public $showPrices = null, $startDate, $endDate, $selectedOfficesIds = [], $selectedMissionId, $mission, $selectedOffices; // inputs
    public $dates, $staticProducts, $missions, $offices, $benefitsTotal, $totalPayed, $daysCount; // outputs

    public function mount($showPrices)
    {
        $this->selectedOffices = collect();
        if (auth()->user()->role->hasPermissionTo('import_model2_create_price')) {
            $this->showPrices = $showPrices;
        }

        $this->offices = (new OfficeController())->getOfficesForUser()->load('OfficeMissions.mission');

    }

    protected function updateDaysCount()
    {
        if ($this->startDate && $this->endDate) {
            $this->daysCount = Carbon::parse($this->startDate)->diffInDays(Carbon::parse($this->endDate)) + 1;
        }
    }

    protected function updatePayed()
    {
        $this->totalPayed = 0;
        if ($this->staticProducts && count($this->staticProducts) > 0) {
            foreach ($this->staticProducts as $staticProduct) {
                $this->totalPayed += $staticProduct['imported_total'] * $staticProduct['price'];
            }
        }
        return $this->totalPayed;
    }

    public function updatedSelectedOfficesIds()
    {
        $this->getSelectedOffices();
        $this->dates = (new ReportSurvice())->getDaysForOffices($this->selectedOffices);
        $this->getStaticProducts();
        $this->updatePayed();

    }

    protected function getSelectedOffices()
    {
        $this->selectedOffices = collect();
        foreach ($this->selectedOfficesIds as $selectedOfficesId) {
            $office = Office::find($selectedOfficesId);
            $this->selectedOffices->push($office);
        }
    }

    public function updatedStartDate()
    {
        // check in end date is coorect and after the start date string to date carbon
        if ($this->startDate && $this->endDate) {
            $this->getStaticProducts();
        }

        $this->updateDaysCount();

        $this->updatePayed();

    }

    protected function getStaticProducts()
    {
        // get reports between the start and end date
        $this->staticProducts = [];
        $this->benefitsTotal = 0;
        if (!$this->startDate || !$this->endDate) {
            return;
        }

        foreach ($this->selectedOffices as $office) {
            $reports = $office->reports()
                ->whereBetween('for_date', [$this->startDate, $this->endDate])->with('import', 'staticProducts')->get();
            foreach ($reports as $report) {
                $staticProductsDB = $report->staticProducts;
                $this->benefitsTotal += $report->import ? $report->import->benefits : 0;

                foreach ($staticProductsDB as $staticProduct) {
                    $staticProductId = $staticProduct->old_id;
                    $staticProductArr = $this->staticProducts[$staticProductId] ?? null;

                    if ($staticProductArr) {
                        // Check if all data is the same
                        $isSameProduct = $staticProductArr['name'] == $staticProduct->name &&
                            $staticProductArr['price'] == $staticProduct->price &&
                            $staticProductArr['daily_amount'] == $staticProduct->daily_amount &&
                            $staticProductArr['food_type_id'] == $staticProduct->food_type_id &&
                            $staticProductArr['food_unit_id'] == $staticProduct->food_unit_id;

                        if ($isSameProduct) {
                            dd($staticProduct);
                            $this->staticProducts[$staticProductId]['totalAmount'] += $staticProduct->day_amount;
                            $this->staticProducts[$staticProductId]['imported_total'] += $staticProduct->total_imported;
                            $this->staticProducts[$staticProductId]['numberPerWeek'] = $staticProduct->number_per_week;
                        } else {
                            $this->insertToStaticProducts($staticProduct);
                        }
                    } else {
                        $this->insertToStaticProducts($staticProduct);
                    }
                }
            }
        }


    }

    protected function insertToStaticProducts($staticProduct)
    {
        $this->staticProducts[$staticProduct->old_id] = [
            'name' => $staticProduct->name,
            'price' => $staticProduct->price,
            'daily_amount' => $staticProduct->daily_amount,
            'food_type_id' => $staticProduct->food_type_id,
            'food_unit_id' => $staticProduct->food_unit_id,
            'unit' => $staticProduct->foodUnit->title,
            'numberPerWeek' => $staticProduct->number_per_week,
            'totalAmount' => $staticProduct->day_amount,
            'imported_total' => $staticProduct->total_imported,
        ];
    }

    // start and end date

    public function updatedEndDate()
    {
        if ($this->startDate && $this->endDate) {
            $this->getStaticProducts();
        }
        $this->updateDaysCount();
        $this->updatePayed();
    }

    public function render()
    {
        return view('livewire.analytics.import-analytics');
    }

    protected function getMission()
    {
        $this->mission = $this->selectedOffice->missions->find($this->selectedMissionId);
        return $this->mission;
    }
}
