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

    public function messages()
    {
        return [
            'selectedOfficeId.required' => 'حقل المقر مطلوب.',
            'selectedDelegateId.required' => 'حقل المندوب مطلوب.',
            'selectedMissionId.required' => 'حقل المهمة مطلوب.',
            'startDate.required' => 'حقل تاريخ البداية مطلوب.',
            'startDate.date' => 'تاريخ البداية يجب أن يكون تاريخاً صالحاً.',
            'startDate.before_or_equal' => 'تاريخ البداية يجب أن يكون قبل أو يساوي تاريخ النهاية.',
            'startDate.not_in' => 'تاريخ البداية المحدد يتداخل مع تقرير موجود مسبقاً.',
            'endDate.required' => 'حقل تاريخ النهاية مطلوب.',
            'endDate.date' => 'تاريخ النهاية يجب أن يكون تاريخاً صالحاً.',
            'endDate.after_or_equal' => 'تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية.',
            'endDate.not_in' => 'تاريخ النهاية المحدد يتداخل مع تقرير موجود مسبقاً.',
        ];
    }

    public function mount(DryFoodReport $dryFoodReport)
    {
        $this->dryFoodReport = $dryFoodReport;

        $this->offices = Office::all()->filter(function ($office) {
            return $office->living->title == 'ميدان';
        });

        $this->delegates = [];
        $this->products = [];
        $this->dates = Day::datesBetween(DryFoodReport::$startDate, DryFoodReport::$endDate);

        if ($this->dryFoodReport->id) {
            $this->selectedOfficeId = $this->dryFoodReport->delegate->office_id;
            $this->selectedDelegateId = $this->dryFoodReport->delegate_id;
            $this->selectedMissionId = $this->dryFoodReport->mission_id;
            $this->startDate = $this->dryFoodReport->start_date;
            $this->endDate = $this->dryFoodReport->end_date;
            $this->delegates = Delegate::where('office_id', $this->selectedOfficeId)->get() ?: [];
            $this->getProducts();
        }
    }

    public function getProducts()
    {
        if ($this->selectedOfficeId && $this->selectedMissionId) {
            $office = Office::find($this->selectedOfficeId);

            $productMissionLivings = ProductLivingMission::where('living_id', $office->living_id)
                ->where('mission_id', $this->selectedMissionId)->get();
            $this->products = $productMissionLivings->map(fn($productMissionLiving) => $productMissionLiving->product);
            // get only products that have both carton and packet values
            $this->products = $this->products->filter(function ($product) {
                return $product->carton_value && $product->packet_value;
            });
        }
    }

    public function updatedSelectedOfficeId()
    {
        $this->delegates = Delegate::where('office_id', $this->selectedOfficeId)->get() ?: [];
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

    protected function rules()
    {
        $dates = [];
        if ($this->selectedDelegateId) {
            $lastReports = DryFoodReport::where('delegate_id', $this->selectedDelegateId)->get();
            foreach ($lastReports as $report) {
                $reportDates = Day::datesBetween($report->start_date, $report->end_date);
                $dates = array_merge($dates, $reportDates);
            }
            if ($this->dryFoodReport->id) {
                $dates = array_diff($dates,
                    Day::datesBetween($this->dryFoodReport->start_date, $this->dryFoodReport->end_date));
            }
        }
        // if start date in the $dates array make validation error message

        return [
            'selectedOfficeId' => 'required',
            'selectedDelegateId' => 'required',
            'selectedMissionId' => 'required',
            'startDate' => 'required|date|before_or_equal:endDate|not_in:'.implode(',', $dates),
            'endDate' => 'required|date|after_or_equal:startDate|not_in:'.implode(',', $dates),
        ];

    }
}
