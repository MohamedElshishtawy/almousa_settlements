<?php

namespace App\Livewire\Analytics;

use App\Models\Day;
use App\Office\Office;
use Livewire\Component;

class BenefitsAnalytics extends Component
{
    public $startDate, $endDate, $offices, $dates, $selectedOffices, $benefits;

    protected function benefitsUpdate() {
        $this->benefits = 0;
        foreach ($this->selectedOffices as $officeId) {
            $office = Office::find($officeId);
            $reports= $office->reports->whereBetween('for_date', [$this->startDate, $this->endDate]);
            $this->benefits += $reports->map(fn ($report) => $report->import ? $report->import->benefits : 0)->sum();
        }
    }
    public function mount()
    {
        $this->offices = Office::all();
        $this->selectedOffices = [];
        $this->dates = [];
        foreach ($this->offices as $office) {
            $this->dates += $office->reports->pluck('for_date')->toArray();
        }

        $this->dates = array_unique($this->dates);
        $this->dates = Day::sortDates($this->dates);

        $this->startDate = $this->dates[0];
        $this->endDate = $this->dates[count($this->dates) - 1];

    }

    public function updatedSelectedOffices()
    {
        $this->benefitsUpdate();
    }

    public function updatedStartDate()
    {
        $this->benefitsUpdate();
    }

    public function updatedEndDate()
    {
        $this->benefitsUpdate();
    }

    public function render()
    {
        return view('livewire.analytics.benefits-analytics');
    }
}
