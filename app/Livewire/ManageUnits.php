<?php

namespace App\Livewire;

use App\Product\FoodUnit;
use Livewire\Component;

class ManageUnits extends Component
{
    public $name;
    public $units;
    public $titles = [];

    // Validation rules
    protected $rules = [
        'name' => 'required|string|max:255|unique:food_units,title',
        'titles.*' => 'required|string|max:255', // Validate each title in the $titles array
    ];

    // Mount the component
    public function mount()
    {
        $this->getUnits();
    }

    // Fetch all units
    protected function getUnits()
    {
        $this->units = FoodUnit::all();
        foreach ($this->units as $unit) {
            $this->titles[$unit->id] = $unit->title;
        }
    }

    // Delete a unit
    public function delete($id)
    {
        $unit = FoodUnit::findOrFail($id);
        $unit->delete();

        // Refresh the units list
        $this->getUnits();
    }

    public function editTitle($unitId)
    {

        // Validate the input
        $this->validate([
            "titles.$unitId" => 'required|string|max:255',
        ]);

        $unit = FoodUnit::findOrFail($unitId);

        // Update the title if it has changed
        if ($unit->title !== $this->titles[$unitId]) {
            $unit->title = $this->titles[$unitId];
            $unit->save();
        }
    }

    // Save a new unit
    public function save()
    {
        // Validate the input
        $this->validate();

        // Create the new unit
        FoodUnit::create(['title' => $this->name]);

        // Reset the input field and refresh the units list
        $this->reset('name');
        $this->getUnits();
    }

    // Render the view
    public function render()
    {
        return view('livewire.manage-units');
    }
}
