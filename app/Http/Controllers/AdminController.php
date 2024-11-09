<?php

namespace App\Http\Controllers;

use App\Living\Living;
use App\Mission\Mission;
use App\Models\Employee;
use App\Models\User;
use App\Office\Office;
use App\Product\FoodUnit;
use App\Product\ProductController;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class AdminController extends Controller
{

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        return view('admin.users', [
            'employees' => Employee::where('role', User::$roles['employee'])->get()
        ]);
    }


    public function createUser()
    {
        return view('admin.create_user');
    }

    public function editUser(Employee $id)
    {
        return view('admin.create_user', [
            'employee' => $id
        ]);
    }

    public function deleteUser(Employee $id)
    {
        $id->delete();
        return redirect()->route('admin.users')->with('message', 'تم حذف الموظف بنجاح');
    }


    public function offices()
    {
        return view('admin.offices', [
            'offices' => Office::all()
        ]);
    }

    public function CreateOffice()
    {
        return view('admin.create_office');
    }


    public function EditOffice(Office $id)
    {
        return view('admin.create_office', [
            'office' => $id
        ]);
    }

    public function DeleteOffice(Office $id)
    {
        $id->delete();
        return redirect()->route('admin.offices')->with('message', 'تم حذف المقر بنجاح');
    }

    public function products()
    {
        return view('admin.products', [
            'counts' => (new ProductController)->countProducts(),
        ]);
    }

    public function all()
    {
        return view('admin.all-products', [
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


}
