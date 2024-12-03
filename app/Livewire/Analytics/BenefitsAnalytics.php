<?php

namespace App\Livewire\Analytics;

use App\Mission\Mission;
use App\Models\Day;
use App\Models\HijriDate;
use App\Office\Office;
use Livewire\Component;

class BenefitsAnalytics extends Component
{
    public $startDate, $endDate, $selectedOffices, $selectedMissions, // inputs
        $missions, $offices, $dates, // data
        $datesBetween, $mission, $year; // outputs

    protected function dataUpdate() {
        $this->year = HijriDate::where('gregorian_date', $this->startDate)->first()->year;
    }
    public function mount()
    {
        $this->offices = Office::all();
        $this->missions = Mission::all();
        $this->selectedOffices = [];
        $this->selectedMissions = [];
        $this->dates = [];
        $this->benefits = 0;
        foreach ($this->offices as $office) {
            $this->dates += $office->reports->pluck('for_date')->toArray();
        }

        $this->dates = array_unique($this->dates);
        $this->dates = Day::sortDates($this->dates);

        $this->startDate = $this->dates[0];
        $this->endDate = $this->dates[count($this->dates) - 1];

        $this->datesBetween = Day::datesBetween($this->startDate, $this->endDate);

    }

    public function updatedSelectedOffices()
    {

        $this->dataUpdate();
    }

    public function updatedStartDate()
    {
        $this->datesBetween = Day::datesBetween($this->startDate, $this->endDate);
        $this->dataUpdate();
    }

    public function updatedEndDate()
    {
        $this->datesBetween = Day::datesBetween($this->startDate, $this->endDate);
        $this->dataUpdate();
    }

    public function render()
    {
        return view('livewire.analytics.benefits-analytics');
    }
}
