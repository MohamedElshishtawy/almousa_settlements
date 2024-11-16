<?php

namespace App\Livewire;

use App\Models\Day;
use App\Models\Meal;
use App\Product\Product;
use App\Product\ProductController;
use App\Product\ProductDayMeal;
use App\Product\ProductLivingMission;
use Livewire\Component;

class ProductMissionEdit extends Component
{
    public $index, $price, $daily_amount, $product, $mission, $living, $productLivingMission, $times_per_week;

    public function mount()
    {
        $this->productLivingMission = ProductLivingMission::where('product_id', $this->product->id)
            ->where('living_id', $this->living->id)
            ->where('mission_id', $this->mission->id)
            ->first();
        $this->times_per_week = $this->product->getHowManyDayPerWeekUsed($this->productLivingMission);
        $this->price = $this->productLivingMission->price;
        $this->daily_amount = $this->productLivingMission->daily_amount;
    }

    public function updated()
    {
        // Update the product
        $this->productLivingMission->update([
            'price' => $this->price ?: 0,
            'daily_amount' => $this->daily_amount ?: 0,
        ]);
        $this->product->save();
    }

    public function toggleDayMeal($dayId, $mealId)
    {

        $check = ProductDayMeal::where('product_living_mission_id', $this->productLivingMission->id)
            ->where('day_id', $dayId)
            ->where('meal_id', $mealId)
            ->first();

        if ($check) {
            $check->delete();
        }
        else {
            ProductDayMeal::create([
                'product_living_mission_id' => $this->productLivingMission->id,
                'day_id' => $dayId,
                'meal_id' => $mealId
            ]);
        }

        $this->times_per_week = $this->product->getHowManyDayPerWeekUsed($this->productLivingMission);
    }



    public function render()
    {
        return view('livewire.product-mission-edit');
    }
}
