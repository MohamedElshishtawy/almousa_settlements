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
        $user = auth()->user();
        $allDelegateAbsence = DelegateAbsence::with('delegate', 'meal')->get();
        if ($user->office) {
            $delegateAbsences = $allDelegateAbsence->filter(fn($delegateAbsence
            ) => $delegateAbsence->delegate->office_id === $user->office->id);
            $delegates = Delegate::where('office_id', $user->office->id)->get();
        } else {
            $delegateAbsences = $allDelegateAbsence;
            $delegates = Delegate::all();
        }

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

        // check if the user is in the office choiced
        $delegate = Delegate::find($this->delegate_id);
        $user = auth()->user();
        if ($user->office && auth()->user()->office_id !== $delegate->office_id) {
            abort(403);
        }

        DelegateAbsence::create([
            'for_date' => $this->for_date,
            'delegate_id' => $this->delegate_id,
            'meal_id' => $this->meal_id,
        ]);

        activity('delegate_absence')
            ->causedBy(auth()->user())
            ->performedOn($delegate)
            ->withProperties(['delegate_id' => $delegate->id])
            ->log('تم اضافة محضر غياب لمندوب');

        session()->flash('تم حفظ محضر غياب المندوب بنجاح');

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
        $delegateAbsence = DelegateAbsence::find($id);

        if ($delegateAbsence) {
            $delegateAbsence->delete();
            activity('delegate_absence')
                ->causedBy(auth()->user())
                ->performedOn(DelegateAbsence::find($id))
                ->withProperties([
                    'delegate_id' => DelegateAbsence::find($id)->delegate_id,
                    'old' => $delegateAbsence->getOriginal()
                ])
                ->log('تم حذف محضر غياب لمندوب');

            session()->flash('تك حذف المحضر بنجاح');
        }

    }
}

