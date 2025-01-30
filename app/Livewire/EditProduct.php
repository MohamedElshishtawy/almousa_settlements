<?php

namespace App\Livewire;

use App\Product\Product;
use Livewire\Component;


class EditProduct extends Component
{

    public Product $product;
    public $name, $food_type_id, $food_unit_id, $carton_value, $packet_value, $isBreakFast;
    public $index, $mission, $living, $units, $types;

    public function mount($product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->food_type_id = $product->food_type_id;
        $this->food_unit_id = $product->food_unit_id;
        $this->carton_value = $product->carton_value;
        $this->packet_value = $product->packet_value;
        $this->isBreakFast = $product->is_break_fast;
    }

    // Load the meals for each product into the component's state


    // This will update the product when any field is changed
    public function updated()
    {
        $this->product->update([
            'name' => $this->name,
            'food_type_id' => $this->food_type_id,
            'food_unit_id' => $this->food_unit_id,
            'carton_value' => $this->carton_value,
            'packet_value' => $this->packet_value,
            'is_break_fast' => $this->isBreakFast,
        ]);
        $this->product->save();
    }

    public function ToggleIsBreakFast()
    {
        $breakfastProduct = $this->product->breakFastProduct;

        if ($this->isBreakFast = !$this->isBreakFast) {
                $breakfastProduct ?? $this->product->breakFastProduct()->create([
                'daily_amount' => 0,
                'price' => 0,
            ]);
        } elseif ($breakfastProduct) {
            $breakfastProduct->delete();
        }

        $this->updated();
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
        }

        // take action to refresh the data
        $this->dispatch('deleted');

    }


    public function render()
    {
        return view('livewire.edit-product');
    }
}
