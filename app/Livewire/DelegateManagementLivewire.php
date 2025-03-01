<?php

namespace App\Livewire;

use App\Models\Delegate;
use App\Office\Office;
use App\Product\FoodType;
use Livewire\Component;

class DelegateManagementLivewire extends Component
{
    public $delegates, $foodTypes, $offices, $delegate;
    public $number, $name, $institution, $rank, $benefits, $food_type_id, $office_id, $phone;


    protected $rules = [
        'number' => 'required|integer|min:1',
        'name' => 'required|string|max:255',
        'institution' => 'required|string|max:255',
        'rank' => 'nullable|string|max:255',
        'benefits' => 'required|integer|min:0',
        'food_type_id' => 'required|integer|exists:food_types,id',
        'office_id' => 'required|integer|exists:offices,id',
        'phone' => 'required'
    ];


    public function mount(Delegate $delegate)
    {
        $user = auth()->user();
        $this->delegates = Delegate::all();
        $this->foodTypes = FoodType::all();
        if ($user->office) {
            $this->offices = Office::where('id', $user->office->id)->get();
        } else {
            $this->offices = Office::all();
        }
        $this->delegate = $delegate;
        if ($delegate) {
            $this->number = $delegate->number;
            $this->name = $delegate->name;
            $this->institution = $delegate->institution;
            $this->rank = $delegate->rank;
            $this->benefits = $delegate->benefits;
            $this->food_type_id = $delegate->food_type_id;
            $this->office_id = $delegate->office_id;
            $this->phone = $delegate->phone;
        }
    }

    public function save()
    {

        $this->validate();

        $isNew = is_null($this->delegate);

        $this->delegate = Delegate::updateOrCreate(['id' => optional($this->delegate)->id], [
            'number' => $this->number,
            'name' => $this->name,
            'institution' => $this->institution,
            'rank' => $this->rank,
            'benefits' => $this->benefits,
            'food_type_id' => $this->food_type_id,
            'office_id' => $this->office_id,
            'phone' => $this->phone,
        ]);

        activity('delegate')
            ->causedBy(auth()->user())
            ->performedOn($this->delegate)
            ->withProperties(['delegate' => $this->delegate])
            ->log($isNew ? 'تم إضافة مندوب' : 'تم تعديل مندوب');

        redirect()->route('admin.delegates')->with('success',
            $isNew ? 'تم إضافة المندوب بنجاح' : 'تم تعديل المندوب بنجاح');

    }

    public function render()
    {
        return view('livewire.delegate-management-livewire');
    }
}
