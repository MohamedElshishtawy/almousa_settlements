<?php

namespace App\Http\Controllers;

use App\Living\Living;
use App\Mission\Mission;
use App\Product\FoodUnit;
use App\Product\ProductController;

class AdminController extends Controller
{

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function products()
    {
        return view('admin.products', [
            'counts' => (new ProductController)->countProducts(),
        ]);
    }

    public function productsSpecific(Mission $mission, Living $living)
    {
        return view('admin.product-day-meal', [
            'mission' => $mission,
            'living' => $living,
        ]);
    }

    public function units()
    {
        $units = FoodUnit::all();
        return view('admin.units', compact('units'));
    }

    public function all()
    {
        return view('admin.all-products', [
            'counts' => (new ProductController)->countProducts(),
        ]);
    }

    public function permissionManagement()
    {
        return view('admin.permission-management');
    }


}
