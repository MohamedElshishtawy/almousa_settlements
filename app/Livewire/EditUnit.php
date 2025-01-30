<?php

namespace App\Livewire;

use Livewire\Component;

class EditUnit extends Component
{
    public $unit, $n;


    public function render()
    {
        return view('livewire.edit-unit');
    }
}
