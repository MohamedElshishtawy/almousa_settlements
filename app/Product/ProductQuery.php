<?php

namespace App\Product;

class ProductQuery
{


    public function getProductsSpecific($mission, $living)
    {
        $productLivingMission = ProductLivingMission::where('living_id', $living)->where('mission_id', $mission)->get();
        $products = collect();
        foreach ($productLivingMission as $item) {
            $products->push(Product::find($item->product_id));
        }
        return $products;
    }

    public function countProductsSpecific($mission, $living)
    {
        return ProductLivingMission::where('living_id', $living)->where('mission_id', $mission)->count();
    }


}
