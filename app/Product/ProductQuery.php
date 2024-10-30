<?php

namespace App\Product;

use App\Office\Office;

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

    public function getProducts($office)
    {
        // check the data type
        if (!is_object($office)) {
            $office = Office::find($office);
        }


        $products = collect();
        $productLivingMission = ProductLivingMission::where('living_id', $office->living_id)
            ->where('mission_id', $office->mission_id)->get();
        foreach ($productLivingMission as $item) {
            // if the product have any value == null don't push
            $product = Product::find($item->product_id);

            if ($product->name &&
                $product->price &&
                $product->daily_amount &&
                $product->food_type_id &&
                $product->food_unit_id) {
                $products->push($product);
            }
        }
        return $products;
    }



}
