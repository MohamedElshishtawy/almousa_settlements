<?php

namespace App\Livewire;

use App\DelegateAbcence\DelegateAbsence;
use App\Models\Delegate;
use App\Models\Meal;
use Livewire\Component;

class DelegateAbcenceLivewire extends Component
{
    public $for_date;
    public $delegate_id;
    public $meal_id;

    protected $rules = [
        'for_date' => 'required|date',
        'delegate_id' => 'required|exists:delegates,id',
        'meal_id' => 'required|exists:meals,id',
    ];

    public function render()
    {
        $delegateAbsences = DelegateAbsence::with('delegate', 'meal')->get();
        $delegates = Delegate::all();
        $meals = Meal::all();

        return view('livewire.delegate-abcence-livewire', [
            'delegateAbsences' => $delegateAbsences,
            'delegates' => $delegates,
            'meals' => $meals,
        ]);
    }

    public function save()
    {
        $this->validate();

        DelegateAbsence::create([
            'for_date' => $this->for_date,
            'delegate_id' => $this->delegate_id,
            'meal_id' => $this->meal_id,
        ]);

        $this->resetForm();
    }

    protected function resetForm()
    {
        $this->for_date = null;
        $this->delegate_id = null;
        $this->meal_id = null;
    }

    public function delete($id)
    {
        DelegateAbsence::find($id)->delete();
    }
}

