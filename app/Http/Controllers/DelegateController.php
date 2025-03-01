<?php

namespace App\Http\Controllers;

use App\Models\Delegate;
use App\Models\DelegateHistory;
use App\Office\Office;
use App\Product\FoodType;

class DelegateController extends Controller
{
    public function index()
    {
        $delegates = Delegate::all();
        $delegateHistory = DelegateHistory::all()->groupBy('name');
        return view('delegates.index', compact('delegates', 'delegateHistory'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->office) {
            $offices = Office::where('id', $user->office->id)->get();
        } else {
            $offices = Office::all();
        }

        $foodTypes = FoodType::all();
        return view('delegates.create', compact('offices', 'foodTypes'));
    }

    public function edit(Delegate $delegate)
    {
        $offices = Office::all();
        $foodTypes = FoodType::all();
        return view('delegates.edit', compact('delegate', 'offices', 'foodTypes'));
    }

    public function delete(Delegate $delegate)
    {
        $delegate->delete();

        activity('delegate')
            ->causedBy(auth()->user())
            ->performedOn($delegate)
            ->withProperties(['delegate' => $delegate])
            ->log('تم حذف مندوب');

        return redirect()->route('admin.delegates')->with('success', 'تم حذف المندوب بنجاح');
    }

}
