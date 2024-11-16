<?php

namespace App\Product;

class ProductService
{
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getHowManyDayPerWeekUsed()
    {
        return $this->product->productsDayMeal()->select('day_id')->groupBy('day_id')->get()->count();
    }
}
