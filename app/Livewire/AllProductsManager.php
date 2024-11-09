<?php

namespace App\Livewire;

use App\Product\FoodType;
use App\Product\FoodUnit;
use App\Product\Product;
use App\Product\ProductLivingMission;
use Livewire\Component;

class AllProductsManager extends Component
{
    public $products;
    public $units, $types, $index = 0;
    protected $listeners = [
        'deleted' => 'fresh',
    ];

    public function fresh()
    {
        $this->products = $this->getProducts();
    }
    protected function getProducts() {
        // Retrieve products specific to the mission and living
        return Product::all();
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



        // Refresh the products list
        $this->products = $this->getProducts();
    }
    public function render()
    {
        return view('livewire.all-products-manager', [
            'products' => $this->products,
            'units' => $this->units,
            'types' => $this->types,
        ]);
    }
}
