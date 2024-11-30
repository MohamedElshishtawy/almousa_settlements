<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HijriDateController extends Controller
{
    public function index()
    {
        return view('admin.hijri-date');
    }
}
