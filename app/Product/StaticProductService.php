<?php

namespace App\Product;

class StaticProductService
{
    public function __construct(StaticProduct $staticProduct)
    {
        $this->staticProduct = $staticProduct;
    }

    public function getHowManyDayPerWeekUsed($id, $fromStatic = false)
    {
        return $this->staticProduct->productsDayMeal()->select('day_id')->groupBy('day_id')->get()->count();
    }
}
