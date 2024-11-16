<?php

namespace App\Product;

use App\Http\Controllers\Controller;
use App\Living\Living;
use App\Mission\Mission;

class ProductController extends Controller
{

    public function getProductsSpecific(Mission $mission, Living $living)
    {
        return (new ProductQuery())->getProductsSpecific($mission->id, $living->id);
    }

    public function countProducts()
    {
        $counts  = [];
        $missions = Mission::all();
        $livings = Living::all();

        foreach ($missions as $mission) {
            foreach ($livings as $living) {
                $counts[$mission->id][$living->id] = (new ProductQuery())
                    ->countProductsSpecific($mission->id, $living->id);
            }
        }

        return $counts;
    }



    public function getProducts($officeMission)
    {
        return (new ProductQuery())->getProducts($officeMission);
    }

}
