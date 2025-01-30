<?php

namespace App\Http\Controllers;

class CompanyController extends Controller
{
    public function companies()
    {
        return view('company.index');
    }
}
