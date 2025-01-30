<?php

namespace App\Livewire;

use App\Employment\FormEmployment;
use App\Employment\FormEmploymentElement;
use Livewire\Component;

class FormEmploymentLivewire extends Component
{
    public $import;
    public $formEmployment;
    public $countState, $cleaningState, $healthState;
    public $formEmploymentArr = [];
    public $counts = [];
    public $titles = [];
    public $benefits = [];
    public $mainCounts = [];
    protected $employments;
    protected $fromEmploymentElements;

    // rules
    protected $rules = [
        'countState' => 'required|max:225',
        'cleaningState' => 'required|max:225',
        'healthState' => 'required|max:225',
        'counts.*' => 'required|numeric',
        'titles.*' => 'required',
    ];

    public function mount($import)
    {
        $this->import = $import;
        $this->employments = $import->report->office->living->employments;
        $this->getEmployment();
    }

    protected function getEmployment()
    {
        $this->formEmployment = $this->import->formEmployment;

        if ($this->formEmployment) {
            $this->loadExistingEmployment();
        } else {
            $this->loadDefaultEmployment();
        }
    }

    protected function loadExistingEmployment()
    {
        $this->countState = $this->formEmployment->count_state;
        $this->cleaningState = $this->formEmployment->cleaning_state;
        $this->healthState = $this->formEmployment->health_state;

        if ($this->formEmployment->formEmploymentElements->count() > 0) {
            foreach ($this->formEmployment->formEmploymentElements as $element) {
                $this->formEmploymentArr[] = [
                    'id' => $element->id,
                    'title' => $element->title,
                    'count' => $element->count,
                ];
                $this->counts[$element->id] = $element->count;
                $this->titles[$element->id] = $element->title;
                $this->benefits[$element->id] = $element->benefits;
                $this->mainCounts[$element->id] = $element->main_count;
            }
        }
    }

    protected function loadDefaultEmployment()
    {
        foreach ($this->employments as $element) {
            $this->formEmploymentArr[] = [
                'id' => null,
                'title' => $element->title,
                'count' => $element->getEmploymentRealCount($this->import->getBenefits()),
            ];
            $this->counts[] = $element->getEmploymentRealCount($this->import->getBenefits());
            $this->titles[] = $element->title;
            $this->benefits[] = $element->benefits;
            $this->mainCounts[] = $element->count;
        }
    }

    public function updateWrittenState($filed, $snakeCase, $value)
    {
        $this->$filed = $value;
        if ($this->formEmployment) {
            $this->formEmployment->$snakeCase = $value;
            $this->formEmployment->save();
        }
    }

    public function save()
    {

        $this->validate();

        $this->createFormEmployment();

        $this->createEmploymentElementElemnts();

    }

    /**
     * @return void
     */
    protected function createFormEmployment(): void
    {
        $this->formEmployment = $this->import->formEmployment ?? new FormEmployment();
        $this->formEmployment->count_state = $this->countState;
        $this->formEmployment->cleaning_state = $this->cleaningState;
        $this->formEmployment->health_state = $this->healthState;
        $this->formEmployment->import_id = $this->import->id;
        $this->formEmployment->save();
    }

    /**
     * @return void
     */
    protected function createEmploymentElementElemnts(): void
    {
        foreach ($this->counts as $index => $count) {
            $formEmploymentElement = new FormEmploymentElement();
            $formEmploymentElement->title = $this->titles[$index];
            $formEmploymentElement->count = $count;
            $formEmploymentElement->benefits = $this->benefits[$index];
            $formEmploymentElement->main_count = $this->mainCounts[$index];
            $formEmploymentElement->form_employment_id = $this->formEmployment->id;
            $formEmploymentElement->save();
        }
    }

    public function edit()
    {

        $this->validate();

        foreach ($this->formEmploymentArr as $id => $element) {
            $formEmploymentElement = FormEmploymentElement::find($element['id']);
            $formEmploymentElement->delete();
        }

        $this->createFormEmployment();

        $this->createEmploymentElementElemnts();

    }

    public function delete()
    {
        if ($this->formEmployment) {
            $this->formEmployment->delete();
            $this->formEmployment->formEmploymentElements()->delete();
        }
        $for_date = $this->import->report->for_date;
        $importId = $this->import->report->id;
        $this->redirect(route('managers.reports.import', [$importId, $for_date]));

    }

    public function updateCounts($formEmploymentElementId, $value)
    {
        $this->counts[$formEmploymentElementId] = $value;
        $this->checkCounts();
    }

    protected function checkCounts()
    {
        $check = true;
        if ($this->formEmployment) {
            $this->formEmployment->formEmploymentElements->each(function ($element) use (&$check) {
                if ($element->main_count > $this->counts[$element->id]) {
                    $check = false;
                }
            });
        } else {
            foreach ($this->counts as $index => $count) {
                if ($count != $this->mainCounts[$index]) {
                    $check = false;
                }
            }
        }

        if ($check) {
            $this->countState = 'مكتملة';
        } else {
            $this->countState = 'غير مكتملة';
        }
    }

    public function render()
    {
        return view('livewire.form-employment-livewire');
    }

}
