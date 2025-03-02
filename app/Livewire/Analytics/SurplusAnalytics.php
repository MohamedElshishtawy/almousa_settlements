<?php

namespace App\Livewire\Analytics;

use App\Office\Office;
use App\Office\OfficeController;
use App\Product\StaticProductService;
use App\Report\ReportSurvice;
use Carbon\Carbon;
use Livewire\Component;

class SurplusAnalytics extends Component
{
    public Office $office;
    public $showPrices = null, $startDate, $endDate, $selectedOfficesIds = [], $selectedMissionId, $mission, $selectedOffices; // inputs
    public $dates, $staticProducts, $missions, $offices, $benefitsTotal, $surplusTotal, $totalPayed, $totalNotPayed, $daysCount; // outputs

    public function mount($showPrices)
    {
        $this->selectedOffices = collect();
        if (auth()->user()->role->hasPermissionTo('import_model2_create_price')) {
            $this->showPrices = $showPrices;
        }


        $this->offices = (new OfficeController())->getOfficesForUser();

    }

    protected function updateDaysCount()
    {
        if ($this->startDate && $this->endDate) {
            $this->daysCount = Carbon::parse($this->startDate)->diffInDays(Carbon::parse($this->endDate)) + 1;
        }
    }

    public function updatedSelectedOfficesIds()
    {
        $this->getOffices();
        $this->dates = (new ReportSurvice())->getDaysForOffices($this->selectedOffices);
        $this->getStaticProducts();
    }

    protected function getOffices(): void
    {
        $this->selectedOffices = collect();
        foreach ($this->selectedOfficesIds as $selectedOfficesId) {
            $office = Office::find($selectedOfficesId);
            if ($office) {
                $this->selectedOffices->push($office);
            }
        }
    }

    public function updatedStartDate()
    {
        // check in end date is coorect and after the start date string to date carbon
        if ($this->startDate && $this->endDate) {
            $this->getStaticProducts();
        }

        $this->updateDaysCount();

    }

    protected function getStaticProducts()
    {
        // get reports between the start and end date
        $this->staticProducts = [];
        $this->benefitsTotal = 0;
        $this->totalPayed = 0;
        $this->totalNotPayed = 0;

        /*
         *
           $this->totalNotPayed += ($staticProduct['total_surplus']) * $staticProduct['price'] / $staticProduct['daily_amount'];
        */

        if (!$this->startDate || !$this->endDate) {
            return;
        }

        foreach ($this->selectedOffices as $office) {
            $reports = $office->reports()->whereBetween('for_date', [$this->startDate, $this->endDate])->get();

            foreach ($reports as $report) {
                $staticProducts = $report->staticProducts;
                $this->benefitsTotal += $report->import ? $report->import->benefits : 0;

                // if there are a static product in $this->staticReports with the same data as $staticProduct, then add the amount to the existing one
                if ($report->staticProducts) {
                    foreach ($report->staticProducts as $staticProduct) {
                        $staticProductArr = $this->staticProducts[$staticProduct->old_id] ?? [];
                        $totalSurplus = (new StaticProductService($staticProduct))->getAllSurplus();

                        $this->totalPayed += optional($staticProduct->importProductError)->error * $staticProduct['price'];
                        $this->totalNotPayed += $totalSurplus * $staticProduct['price'];

                        if ($staticProductArr &&
                            $staticProductArr['name'] == $staticProduct->name &&
                            $staticProductArr['price'] == $staticProduct->price &&
                            $staticProductArr['daily_amount'] == $staticProduct->daily_amount &&
                            $staticProductArr['food_type_id'] == $staticProduct->food_type_id &&
                            $staticProductArr['food_unit_id'] == $staticProduct->food_unit_id
                        ) {
                            $staticProductArr['numberPerWeek'] = $staticProduct->getHowManyDayPerWeekUsed();
                            $staticProductArr['totalAmount'] += $report->import->benefits * $staticProduct->daily_amount;
                            $staticProductArr['imported_total'] += optional($staticProduct->importProductError)->error;
                            $staticProductArr['total_surplus'] += $totalSurplus;
                        } else {
                            $this->staticProducts[$staticProduct->old_id] = [
                                'name' => $staticProduct->name,
                                'price' => $staticProduct->price,
                                'daily_amount' => $staticProduct->daily_amount,
                                'food_type_id' => $staticProduct->food_type_id,
                                'food_unit_id' => $staticProduct->food_unit_id,
                                'unit' => $staticProduct->foodUnit->title,
                                'numberPerWeek' => $staticProduct->getHowManyDayPerWeekUsed(),
                                'totalAmount' => $report->import->benefits * $staticProduct->daily_amount, //
                                'imported_total' => optional($staticProduct->importProductError)->error, //
                                'total_surplus' => $totalSurplus, //
                            ];
                        }
                    }
                }

            }
        }
    }

    // start and end date
    public function updatedEndDate()
    {
        if ($this->startDate && $this->endDate) {
            $this->getStaticProducts();
        }
        $this->updateDaysCount();
    }


    public function render()
    {
        return view('livewire.analytics.surplus-analytics');
    }

    protected function getMission()
    {
        $this->mission = $this->selectedOffice->missions->find($this->selectedMissionId);
        return $this->mission;
    }
}
