<?php

namespace App\Livewire;

use App\Product\FoodUnit;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class EditUnit extends Component
{
    public $unit, $n;



    public function render()
    {
        return view('livewire.edit-unit');
    }
}
