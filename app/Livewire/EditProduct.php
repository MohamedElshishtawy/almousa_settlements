<?php
namespace App\Livewire;

use App\Product\Product;
use App\Product\ProductDayMeal;
use Livewire\Component;


class EditProduct extends Component
{

    public Product $product;
    public $name, $price, $food_type_id, $food_unit_id, $daily_amount, $times_per_week, $meals;
    public $index, $mission, $living, $units, $types;

    public function mount($product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->food_type_id = $product->food_type_id;
        $this->food_unit_id = $product->food_unit_id;
        $this->daily_amount = $product->daily_amount;
        $this->times_per_week = $product->pdoductsDayMeal()->count();
//        $this->meals = $this->loadMeals($product);  // This assumes meals are stored as relations or attributes
    }

    // Load the meals for each product into the component's state


    // This will update the product when any field is changed
    public function updated($field)
    {

        // Update the product
        $this->product->update([
            'name' => $this->name,
            'price' => $this->price,
            'food_type_id' => $this->food_type_id,
            'food_unit_id' => $this->food_unit_id,
            'daily_amount' => $this->daily_amount,
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
        $this->times_per_week = $this->product->pdoductsDayMeal()->count();
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
