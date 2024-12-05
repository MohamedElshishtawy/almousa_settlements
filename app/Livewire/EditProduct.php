<?php
namespace App\Livewire;

use App\Product\Product;
use App\Product\ProductController;
use App\Product\ProductDayMeal;
use App\Product\ProductLivingMission;
use Livewire\Component;


class EditProduct extends Component
{

    public Product $product;
    public $name, $food_type_id, $food_unit_id, $carton_value, $packet_value;
    public $index, $mission, $living, $units, $types;

    public function mount($product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->food_type_id = $product->food_type_id;
        $this->food_unit_id = $product->food_unit_id;
        $this->carton_value = $product->carton_value;
        $this->packet_value = $product->packet_value;
    }

    // Load the meals for each product into the component's state


    // This will update the product when any field is changed
    public function updated($field)
    {

        // Update the product
        $this->product->update([
            'name' => $this->name,
            'food_type_id' => $this->food_type_id,
            'food_unit_id' => $this->food_unit_id,
            'carton_value' => $this->carton_value,
            'packet_value' => $this->packet_value,
        ]);
        $this->product->save();
    }

    public function toggleDayMeal($dayId, $mealId)
    {
        $check = ProductDayMeal::where('product_id', $this->product->id)
            ->where('day_id', $dayId)
            ->where('meal_id', $mealId)
            ->first();
        if ($check) {
            $check->delete();
        }
        else {
            ProductDayMeal::create([
                'product_id' => $this->product->id,
                'day_id' => $dayId,
                'meal_id' => $mealId
            ]);
        }
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
