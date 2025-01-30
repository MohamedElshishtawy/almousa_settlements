<?php

namespace App\Livewire;

use App\Product\FoodUnit;
use Livewire\Component;

class ManageUnits extends Component
{

    public $name;


    public $units;
    public $titles = [];

    public function delete($id)
    {
        $unit = FoodUnit::find($id);
        $unit->delete();
        $this->getUnites();

    }

    protected function getUnites()
    {
        $this->units = FoodUnit::all();
        foreach ($this->units as $unit) {
            $this->titles[$unit->id] = $unit->title;
        }
    }

    public function editTitle($unitId)
    {
        $unit = FoodUnit::find($unitId);
        if ($unit->title != $this->titles[$unitId]) {
            $unit->title = $this->titles[$unitId];
        } elseif (!$unit->title) {
            $unit->title = 'غير معروف';
        }
        $unit->save();
    }

    public function save()
    {
        if ($this->name) {
            FoodUnit::create(['title' => $this->name]);
            $this->units = FoodUnit::all();
            $this->name = '';
        }
        $this->getUnites();
    }

    public function mount()
    {
        $this->getUnites();
    }

    public function render()
    {
        return view('livewire.manage-units');
    }
}
