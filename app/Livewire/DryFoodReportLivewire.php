<?php

namespace App\Livewire;

use App\Models\Day;
use App\Models\Delegate;
use App\Models\DryFoodReport;
use App\Office\Office;
use App\Product\Product;
use App\Product\ProductLivingMission;
use Livewire\Component;

class DryFoodReportLivewire extends Component
{
    public $offices, $delegates, $dates, $missions;
    public $selectedOfficeId, $selectedDelegateId, $selectedMissionId, $startDate, $endDate;
    public $products;
    public DryFoodReport $dryFoodReport;

    protected function rules()
    {
        return [
            'selectedOfficeId' => 'required',
            'selectedDelegateId' => 'required',
            'selectedMissionId' => 'required',
            'startDate' => 'required|date|before:endDate',
            'endDate' => 'required|date|after:startDate',
        ];

    }


    public function getProducts() {
        if ($this->selectedOfficeId && $this->selectedMissionId) {
            $office = Office::find($this->selectedOfficeId);

            $productMissionLivings = ProductLivingMission::where('living_id', $office->living_id)
                ->where('mission_id', $this->selectedMissionId)->get();
            $this->products = $productMissionLivings->map(fn ($productMissionLiving) => $productMissionLiving->product);
        }
    }

    public function mount(DryFoodReport $dryFoodReport)
    {
        $this->dryFoodReport = $dryFoodReport;

        $this->offices = Office::all()->filter(function($office) {
            return $office->living->title == 'ميدان';
        });

        $this->delegates = Delegate::all() ?: [];

        $this->dates = Day::datesBetween(DryFoodReport::$startDate, DryFoodReport::$endDate);
        $this->products = [];

        if ($this->dryFoodReport) {
            $this->selectedOfficeId = $this->dryFoodReport->delegate->office_id;
            $this->selectedDelegateId = $this->dryFoodReport->delegate_id;
            $this->selectedMissionId = $this->dryFoodReport->mission_id;
            $this->startDate = $this->dryFoodReport->start_date;
            $this->endDate = $this->dryFoodReport->end_date;
            $this->getProducts();
        }
    }


    public function updatedSelectedOfficeId()
    {
        $this->getProducts();

    }

    public function updatedSelectedMissionId()
    {
        $this->getProducts();

    }

    public function updatedSelectedDelegateId()
    {
        $this->getProducts();

    }

    public function updatedStartDate()
    {
        $this->getProducts();

    }

    public function updatedEndDate()
    {
        $this->getProducts();

    }


    public function save()
    {
        $this->validate();
        $this->dryFoodReport = DryFoodReport::create([
            'delegate_id' => $this->selectedDelegateId,
            'mission_id' => $this->selectedMissionId,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);

        $this->redirect(route('dry-food-reports.edit', $this->dryFoodReport));

    }

    public function edit()
    {
        $this->validate();
        $this->dryFoodReport->update([
            'delegate_id' => $this->selectedDelegateId,
            'mission_id' => $this->selectedMissionId,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);
    }


    public function render()
    {
        return view('livewire.dry-food-report-livewire');
    }
}
