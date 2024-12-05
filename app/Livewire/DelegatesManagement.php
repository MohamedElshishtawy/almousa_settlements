<?php

namespace App\Livewire;

use App\Models\Delegate;
use App\Product\FoodType;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DelegatesManagement extends Component
{
    public $number, $name, $institution, $rank, $benefits, $food_type_id;
    public $delegates, $delegatesNumbers, $delegatesNames, $delegatesInstitutions, $delegatesRanks,$delegatesFoodTypes, $delegatesBenefits;
    public $foodTypes;
    /**
     * Validation rules.
     */
    protected $rules = [
        'number' => 'required|integer|min:1|unique:delegates,number',
        'name' => 'required|string|max:255',
        'institution' => 'required|string|max:255',
        'rank' => 'nullable|string|max:255',
        'benefits' => 'required|integer|min:0',
    ];

    /**
     * Check if the user has the necessary role to perform an action.
     *
     * @param string $role
     * @return bool
     */
    protected function roles(string $role): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole($role);
    }

    protected function changeDelegats()
    {
        $this->delegates = Delegate::all();
        $this->foodTypes = FoodType::all();
        foreach ($this->delegates as $delegate) {
            $this->delegatesNumbers[$delegate->id] = $delegate->number;
            $this->delegatesNames[$delegate->id] = $delegate->name;
            $this->delegatesInstitutions[$delegate->id] = $delegate->institution;
            $this->delegatesRanks[$delegate->id] = $delegate->rank;
            $this->delegatesBenefits[$delegate->id] = $delegate->benefits;
            $this->delegatesFoodTypes[$delegate->id] = $delegate->food_type_id;
        }
    }

    public function mount()
    {
        $this->changeDelegats();
        $this->delegates->sortBy('number');

    }

    public function changeNumber($delegateId, $value)
    {
        $delegate = Delegate::find($delegateId);
        $validatedData = $this->validate([
            "delegatesNumbers.$delegateId" => 'required|integer|min:0',
        ]);
        $delegate->number = $value;
        $delegate->save();
        $this->changeDelegats();
    }

    public function changeName($delegateId, $value)
    {
        $delegate = Delegate::find($delegateId);
        $validatedData = $this->validate([
            "delegatesNames.$delegateId" => 'required|string|max:255',
        ]);
        $delegate->name = $value;
        $delegate->save();
        $this->changeDelegats();
    }

    public function changeInstitution($delegateId, $value)
    {
        $delegate = Delegate::find($delegateId);
        $validatedData = $this->validate([
            "delegatesInstitutions.$delegateId" => 'required|string|max:255',
        ]);
        $delegate->institution = $value;
        $delegate->save();
        $this->changeDelegats();
    }

    public function changeRank($delegateId, $value)
    {
        $delegate = Delegate::find($delegateId);
        $validatedData = $this->validate([
            "delegatesRanks.$delegateId" => 'nullable|string|max:255',
        ]);
        $delegate->rank = $value;
        $delegate->save();
        $this->changeDelegats();
    }

    public function changeBenefits($delegateId, $value)
    {
        $delegate = Delegate::find($delegateId);
        $validatedData = $this->validate([
            "delegatesBenefits.$delegateId" => 'required|integer|min:0',
        ]);
        $delegate->benefits = $value;
        $delegate->save();
        $this->changeDelegats();
    }

    public function changeFoodType($delegateId, $value)
    {
        $delegate = Delegate::find($delegateId);
        $delegate->food_type_id= $value;
        $delegate->save();
        $this->changeDelegats();
    }

    public function store()
    {
        $validatedData = $this->validate();
        Delegate::create($validatedData);
        $this->reset();
        $this->changeDelegats();
    }

    public function delete($delegateId)
    {
        Delegate::find($delegateId)->delete();
        $this->changeDelegats();
    }

    public function render()
    {
        return view('livewire.delegates-management');
    }
}
