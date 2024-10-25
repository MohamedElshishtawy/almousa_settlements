<?php

namespace App\Livewire;

use App\Product\FoodUnit;
use Livewire\Component;

class ManageUnits extends Component
{

    public $units;
    public $name;

    public function mount()
    {
        $this->units = FoodUnit::all();
    }

    public function delete($id)
    {
        $unit = FoodUnit::find($id);
        $unit->delete();
        $this->units = FoodUnit::all();
    }

    public function save()
    {
        if ($this->name) {
            FoodUnit::create(['title' => $this->name]);
            $this->units = FoodUnit::all();
            $this->name = '';
        }
    }

    public function render()
    {
        return view('livewire.manage-units');
    }
}
