<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DelegateController extends Controller
{
    public function index()
    {
        return view('delegates.index');
    }
}
