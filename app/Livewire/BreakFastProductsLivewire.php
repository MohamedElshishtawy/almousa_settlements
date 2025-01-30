<?php

namespace App\Livewire;

use App\BreakFast\BreakFastProduct;
use Livewire\Component;

class BreakFastProductsLivewire extends Component
{
    public $breakfastProducts;
    public $dailyAmounts = [];

    public function mount()
    {
        $this->breakfastProducts = BreakFastProduct::with('product')->get();
        foreach ($this->breakfastProducts as $breakfastProduct) {
            $this->dailyAmounts[$breakfastProduct->id] = $breakfastProduct->daily_amount;
        }
    }

    public function updateDailyAmount($id, $value)
    {
        $breakfastProduct = BreakFastProduct::find($id);
        if ($breakfastProduct->daily_amount != $value) {
            $breakfastProduct->daily_amount = $value;
            $breakfastProduct->save();
        }


    }

    public function render()
    {
        return view('livewire.break-fast-products-livewire');
    }
}
