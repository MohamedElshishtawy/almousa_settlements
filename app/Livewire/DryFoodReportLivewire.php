<?php

namespace App\Livewire;

use App\Models\Day;
use App\Models\Delegate;
use App\Models\DryFoodReport;
use App\Office\Office;
use App\Product\ProductLivingMission;
use Livewire\Component;

class DryFoodReportLivewire extends Component
{
    public $offices, $delegates, $dates, $missions;
    public $selectedOfficeId, $selectedDelegateId, $selectedMissionId, $startDate, $endDate;
    public $products;
    public DryFoodReport $dryFoodReport;

    // Mount the component
    public function mount(DryFoodReport $dryFoodReport)
    {
        $this->dryFoodReport = $dryFoodReport;
        $this->initializeOffices();
        $this->initializeDelegatesAndProducts();
        $this->dates = Day::datesBetween(DryFoodReport::$startDate, DryFoodReport::$endDate);

        if ($this->dryFoodReport->exists) {
            $this->initializeExistingReport();
        }
    }

    // Initialize offices based on user permissions
    protected function initializeOffices()
    {
        $this->offices = Office::all()->filter(function ($office) {
            return $office->living->title == 'ميدان';
        });

        if (auth()->user()->office) {
            $this->offices = $this->offices->filter(function ($office) {
                return auth()->user()->isBelongsToOffice($office->id);
            });
        }
    }

    // Initialize delegates and products
    protected function initializeDelegatesAndProducts()
    {
        $this->delegates = [];
        $this->products = [];
    }

    // Initialize fields for an existing report
    protected function initializeExistingReport()
    {
        $this->selectedOfficeId = $this->dryFoodReport->delegate->office_id;
        $this->selectedDelegateId = $this->dryFoodReport->delegate_id;
        $this->selectedMissionId = $this->dryFoodReport->mission_id;
        $this->startDate = $this->dryFoodReport->start_date;
        $this->endDate = $this->dryFoodReport->end_date;
        $this->delegates = Delegate::where('office_id', $this->selectedOfficeId)->get() ?: [];
        $this->getProducts();
    }

    // Fetch products based on selected office and mission
    public function getProducts()
    {
        if ($this->selectedOfficeId && $this->selectedMissionId) {
            $office = Office::find($this->selectedOfficeId);

            $productMissionLivings = ProductLivingMission::where('living_id', $office->living_id)
                ->where('mission_id', $this->selectedMissionId)->get();

            $this->products = $productMissionLivings->map(fn($productMissionLiving) => $productMissionLiving->product)
                ->filter(function ($product) {
                    return $product->carton_value && $product->packet_value;
                });
        }
    }

    // Handle office selection change
    public function updatedSelectedOfficeId()
    {
        $this->delegates = Delegate::where('office_id', $this->selectedOfficeId)->get() ?: [];
        $this->getProducts();
    }

    // Handle mission selection change
    public function updatedSelectedMissionId()
    {
        $this->getProducts();
    }

    // Handle delegate selection change
    public function updatedSelectedDelegateId()
    {
        $this->getProducts();
    }

    // Handle start date change
    public function updatedStartDate()
    {
        $this->getProducts();
    }

    // Handle end date change
    public function updatedEndDate()
    {
        $this->getProducts();
    }

    // Save a new report
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

    // Update an existing report
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

    // Define validation rules
    protected function rules()
    {
        $dates = $this->getOverlappingDates();
        return [
            'selectedOfficeId' => 'required',
            'selectedDelegateId' => 'required',
            'selectedMissionId' => 'required',
            'startDate' => 'required|date|before_or_equal:endDate|not_in:'.implode(',', $dates),
            'endDate' => 'required|date|after_or_equal:startDate|not_in:'.implode(',', $dates),
        ];
    }

    // Get overlapping dates for validation
    protected function getOverlappingDates()
    {
        $dates = [];
        if ($this->selectedDelegateId) {
            $lastReports = DryFoodReport::where('delegate_id', $this->selectedDelegateId)->get();
            foreach ($lastReports as $report) {
                $reportDates = Day::datesBetween($report->start_date, $report->end_date);
                $dates = array_merge($dates, $reportDates);
            }
            if ($this->dryFoodReport->exists) {
                $dates = array_diff($dates,
                    Day::datesBetween($this->dryFoodReport->start_date, $this->dryFoodReport->end_date));
            }
        }
        return $dates;
    }

    // Render the view
    public function render()
    {
        return view('livewire.dry-food-report-livewire');
    }
}
