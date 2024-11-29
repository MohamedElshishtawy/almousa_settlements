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
    public $showPrices, $startDate, $endDate, $selectedOfficeId, $selectedMissionId, $mission; // inputs
    public $dates, $staticProducts, $missions, $offices, $benefitsTotal, $totalPayed, $daysCount; // outputs


    protected function getOffice()
    {
        $this->office = Office::find($this->selectedOfficeId);
        return $this->office;
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
    protected function updateDaysCount()
    {
        if ($this->startDate && $this->endDate) {
            $this->daysCount = Carbon::parse($this->startDate)->diffInDays(Carbon::parse($this->endDate)) + 1;
        }
    }
    protected function getMission()
    {
        $this->mission = $this->selectedOffice->missions->find($this->selectedMissionId);
        return $this->mission;
    }

    protected function insert($staticProduct) {
        $totalImported = $staticProduct->importProductError ?
            $staticProduct->importProductError->error :($staticProduct->report->import->benefits ?? 0) * $staticProduct->daily_amount;
        $data = [
            'name' => $staticProduct->name,
            'price' => $staticProduct->price,
            'daily_amount' => $staticProduct->daily_amount,
            'food_type_id' => $staticProduct->food_type_id,
            'food_unit_id' => $staticProduct->food_unit_id,
            'unit' => $staticProduct->foodUnit->title,
            'numberPerWeek' => $staticProduct->getHowManyDayPerWeekUsed(),
            'totalAmount' => $staticProduct->daily_amount * $staticProduct->report->import->benefits,
            'imported_total' => $totalImported,
//            'total_surplus' => $staticProduct->getSurplus(),
        ];
        $this->staticProducts[$staticProduct->old_id] = $data;
    }

    protected function getStaticProducts() {
        // get reports between the start and end date
        $this->staticProducts = [];
        $this->benefitsTotal = 0;
        if (!$this->startDate || !$this->endDate) {
            return;
        }
$x=0;
        $reports = $this->office->reports()->whereBetween('for_date', [$this->startDate, $this->endDate])->get();

        foreach ($reports as $report) {
            $staticProducts = $report->staticProducts;
            $this->benefitsTotal += $report->import ? $report->import->benefits : 0;

            // if there are a static product in $this->staticReports with the same data as $staticProduct, then add the amount to the existing one
            foreach ($staticProducts as $staticProduct) {
                if (!in_array($staticProduct->old_id, array_keys($this->staticProducts))) {
                    $this->insert($staticProduct);
                } else {

                   $staticProductArr = $this->staticProducts[$staticProduct->old_id];
                   // check if all data is the same

                     if ($staticProductArr['name'] == $staticProduct->name &&
                         $staticProductArr['price'] == $staticProduct->price &&
                         $staticProductArr['daily_amount'] == $staticProduct->daily_amount &&
                         $staticProductArr['food_type_id'] == $staticProduct->food_type_id &&
                         $staticProductArr['food_unit_id'] == $staticProduct->food_unit_id

                     ) {
                         $totalImported = $staticProduct->importProductError ?
                             $staticProduct->importProductError->error :($staticProduct->report->import->benefits ?? 0) * $staticProduct->daily_amount;

                         $this->staticProducts[$staticProduct->old_id]['totalAmount'] += $staticProduct->daily_amount * $report->import->benefits;
                            $this->staticProducts[$staticProduct->old_id]['imported_total'] += $totalImported;
//                            $this->staticProducts[$staticProduct->old_id]['total_surplus'] += $staticProduct->getSurplus();
                         $staticProductArr['numberPerWeek'] = $staticProduct->getHowManyDayPerWeekUsed();


                     } else {
                         $this->insert($staticProduct);
                     }

                }


            }
        }


    }

    public function mount($showPrices)
    {
        $this->showPrices = $showPrices;
        $this->offices = (new OfficeController())->getOfficesForUser();

        if ($this->offices->count() > 0) {
            $this->office = $this->offices->first();
            $this->mission = $this->offices->first()->OfficeMissions->first()->mission;
            $this->selectedOfficeId = $this->office->id;
            $this->selectedMissionId = $this->mission->id;
            $this->dates = (new ReportSurvice())->getDaysForOffice($this->office);
            if ($this->dates->count()) {
                $this->startDate = $this->dates->first();
                $this->endDate = $this->dates->last();
            }
            $this->updateDaysCount();
            $this->updatePayed();
        }

    }

    public function updatedSelectedOfficeId()
    {
        $this->getOffice();
        $this->dates = (new ReportSurvice())->getDaysForOffice($this->office);
        $this->updatePayed();
    }

    // start and end date
    public function updatedStartDate()
    {
        // check in end date is coorect and after the start date string to date carbon
        if ($this->startDate && $this->endDate ) {
            $this->getStaticProducts();
        }

        $this->updateDaysCount();
        $this->updatePayed();

    }

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
}
