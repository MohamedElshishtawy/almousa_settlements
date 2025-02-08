<?php

namespace App\Livewire;

use App\Models\Day;
use App\Models\Delegate;
use App\Models\DryFoodReport;
use App\Office\Office;
use App\Product\ProductLivingMission;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class DryFoodReportLivewire extends Component
{
    public $offices, $delegates, $dates, $missions;
    public $selectedOfficeId, $selectedDelegateId, $selectedMissionId, $startDate, $endDate;
    public $products;
    public DryFoodReport $dryFoodReport;

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

    protected function initializeOffices()
    {
        $this->offices = Office::all()->filter(fn($office) => $office->living->title == 'ميدان');
        if (auth()->user()->office) {
            $this->offices = $this->offices->filter(fn($office) => auth()->user()->isBelongsToOffice($office->id));
        }
    }

    protected function initializeDelegatesAndProducts()
    {
        $this->delegates = [];
        $this->products = [];
    }

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

    public function getProducts()
    {
        if ($this->selectedOfficeId && $this->selectedMissionId) {
            $office = Office::find($this->selectedOfficeId);
            $productMissionLivings = ProductLivingMission::where('living_id', $office->living_id)
                ->where('mission_id', $this->selectedMissionId)->get();
            $this->products = $productMissionLivings->map(fn($productMissionLiving) => $productMissionLiving->product)
                ->filter(fn($product) => $product->carton_value && $product->packet_value);
        }
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

        activity('dry_food')
            ->causedBy(auth()->user())
            ->withProperties([
                'dry_food_report_id' => $this->dryFoodReport->id,
            ])
            ->performedOn($this->dryFoodReport)->log('تم إنشاء تقرير إعاشة');
        session()->flash('success', 'تم حفظ المحضر بنجاح');
        return redirect()->route('dry-food-reports.edit', $this->dryFoodReport);
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


        activity('dry_food')
            ->causedBy(auth()->user())
            ->withProperties([
                'dry_food_report_id' => $this->dryFoodReport->id,
                'old' => $this->dryFoodReport->getOriginal(),
                'new' => $this->dryFoodReport->getAttributes(),
            ])
            ->performedOn($this->dryFoodReport)->log('تم تعديل تقرير إعاشة');
        Session::flash('success', 'تم تعديل المحضر بنجاح');
    }

    public function delete()
    {
        $this->dryFoodReport->delete();
        activity('dry_food')
            ->causedBy(auth()->user())
            ->withProperties([
                'dry_food_report_id' => $this->dryFoodReport->id,
                'old' => $this->dryFoodReport->getOriginal(),
            ])
            ->performedOn($this->dryFoodReport)->log('تم حذف تقرير إعاشة');

        Session::flash('success', 'تم حذف المحضر بنجاح');
        return redirect()->route('dry-food-reports.index');
    }

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

    public function render()
    {
        return view('livewire.dry-food-report-livewire');
    }
}
