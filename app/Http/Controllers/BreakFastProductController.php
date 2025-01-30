<?php

namespace App\Http\Controllers;

class BreakFastProductController extends Controller
{
    public function index()
    {
        return view('breakfast.products');
    }
}
