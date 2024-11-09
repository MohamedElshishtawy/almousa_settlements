<?php

namespace App\Livewire;

use App\Product\Product;
use App\Product\ProductLivingMission;
use Livewire\Component;

class ProductsDaysMealsManager extends Component
{
    public $missionProducts, $allProducts;
    public $mission, $living, $units, $types, $index = 0;



    protected function getProducts() {
        // Retrieve products specific to the mission and living
        return ProductLivingMission::where('living_id', $this->living->id)
            ->where('mission_id', $this->mission->id)
            ->with('product')
            ->get();
    }

    public function mount()
    {
        // Initial data loading
        $this->missionProducts = $this->getProducts();
        $this->allProducts = Product::all();
    }


    public function toggleProduct($productId)
    {
        $productLivingMission = ProductLivingMission::where('product_id', $productId)
            ->where('living_id', $this->living->id)
            ->where('mission_id', $this->mission->id)
            ->first();
        if ($productLivingMission) {
            $productLivingMission->delete();
        } else {
            ProductLivingMission::create([
                'product_id' => $productId,
                'living_id' => $this->living->id,
                'mission_id' => $this->mission->id,
            ]);
        }
        $this->missionProducts = $this->getProducts();
    }



    public function render()
    {
        return view('livewire.products-days-meals-manager');
    }
}
