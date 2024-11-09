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
    public $name, $food_type_id, $food_unit_id;
    public $index, $mission, $living, $units, $types;

    public function mount($product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->food_type_id = $product->food_type_id;
        $this->food_unit_id = $product->food_unit_id;
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

    // Handle saving meals
    protected function updateMeals()
    {
        // Assuming you have a many-to-many relationship for meals on the Product model
        foreach ($this->meals as $day => $mealValues) {
            foreach ($mealValues as $meal => $checked) {
                // Save the meal values for the specific day (implement this logic as needed)
            }
        }
    }



    public function render()
    {
        return view('livewire.edit-product');
    }
}
