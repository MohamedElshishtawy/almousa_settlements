<?php

namespace App\Product;

use App\Office\OfficeMission;

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
        return ProductLivingMission::where('living_id', $living)
            ->where('mission_id', $mission)
            ->where('price', '>', 0)
            ->where('daily_amount', '>', 0)->count();
    }

    public function getProducts($officeMission)
    {
        // check the data type
        if (!is_object($officeMission)) {
            $officeMission = OfficeMission::find($officeMission);
        }


        $products = collect();
        $productLivingMission = ProductLivingMission::where('living_id', $officeMission->office->living_id)
            ->where('mission_id', $officeMission->mission_id)->get();
        foreach ($productLivingMission as $item) {
            // if the product have any value == null don't push
            $product = Product::find($item->product_id);
            if ($product->name &&
                $product->food_type_id &&
                $product->food_unit_id &&
                $productLivingMission->where('product_id', $product->id)->first()->price &&
                $productLivingMission->where('product_id', $product->id)->first()->daily_amount) {
                $products->push($product);
            }
        }
        return $products;
    }


}
