<?php

namespace App\Livewire;

use App\Product\FoodType;
use App\Product\FoodUnit;
use App\Product\Product;
use App\Product\ProductLivingMission;
use Livewire\Component;


class ProductsManager extends Component
{

    public $products;
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
        $this->products = $this->getProducts();
        $this->units = FoodUnit::all();
        $this->types = FoodType::all();
    }

    public function addProduct()
    {
        // Create a new product and save it to the database
        $newProduct = new Product();
        $newProduct->save();

        // Link the new product to the mission and living
        ProductLivingMission::create([
            'living_id' => $this->living->id,
            'mission_id' => $this->mission->id,
            'product_id' => $newProduct->id,
        ]);

        // Refresh the products list
        $this->products = $this->getProducts();
    }

    public function render()
    {
        return view('livewire.products-manager', [
            'products' => $this->products,
            'units' => $this->units,
            'types' => $this->types,
        ]);
    }
}
