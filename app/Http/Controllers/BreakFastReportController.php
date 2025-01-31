<?php

namespace App\Http\Controllers;

use App\BreakFast\BreakFastProduct;
use App\BreakFast\BreakFastReport;
use App\BreakFast\BreakFastReportDelegate;
use App\BreakFast\BreakFastReportProduct;
use App\Models\Delegate;
use Illuminate\Http\Request;

class BreakFastReportController extends Controller
{
    public function index()
    {
        $breakFastReports = BreakFastReport::with('breakFastReportDelegates')->latest()->get();

        return view('breakfast.index', compact('breakFastReports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'for_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
            'delegates' => 'required|array',
            'delegates.*' => 'exists:delegates,id',
        ]);

        $breakFastReport = BreakFastReport::create($request->only('for_date', 'notes'));

        foreach ($request->delegates as $delegateId) {
            BreakFastReportDelegate::create([
                'break_fast_report_id' => $breakFastReport->id,
                'delegate_id' => $delegateId,
            ]);
        }

        $breakFastProducts = BreakFastProduct::with('product')->get();

        foreach ($breakFastProducts as $breakFastProduct) {
            BreakFastReportProduct::create([
                'break_fast_report_id' => $breakFastReport->id,
                'break_fast_product_id' => $breakFastProduct->id,
                'product_id' => $breakFastProduct->product_id,
                'daily_amount' => $breakFastProduct->daily_amount,
                'price' => $breakFastProduct->price,
            ]);
        }

        return redirect()->route('breakfast.index')->with('message', 'تم إضافة التقرير بنجاح');
    }

    public function create()
    {
        $breakFastReport = new BreakFastReport();
        $delegatesAll = Delegate::all();
        return view('breakfast.form', compact('breakFastReport', 'delegatesAll'));
    }

    public function edit($id)
    {
        $breakFastReport = BreakFastReport::with('breakFastReportDelegates')->findOrFail($id);
        $delegatesAll = Delegate::all();

        return view('breakfast.form', compact('breakFastReport', 'delegatesAll'));
    }

    public function update(Request $request, $id)
    {
        $breakFastReport = BreakFastReport::findOrFail($id);

        $request->validate([
            'for_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
            'delegates' => 'required|array',
            'delegates.*' => 'exists:delegates,id',
        ]);

        $breakFastReport->update($request->only('for_date', 'notes'));

        // Sync delegates
        BreakFastReportDelegate::where('break_fast_report_id', $breakFastReport->id)->delete();

        foreach ($request->delegates as $delegateId) {
            BreakFastReportDelegate::create([
                'break_fast_report_id' => $breakFastReport->id,
                'delegate_id' => $delegateId,
            ]);
        }

        return redirect()->route('breakfast.index')->with('message', 'تم تحديث التقرير بنجاح');
    }

    public function print(BreakFastReport $breakFastReport) // Changed to show and accept ID
    {

        // Find the BreakFastReport by ID, eager loading relationships
        $breakfastReport = BreakFastReport::with([
            'breakFastReportProducts.breakFastProduct.product',
            'breakFastReportDelegates.delegate'
        ])->find($breakFastReport->id);

        // Extract data for the view
        $breakfastReportDelegates = $breakfastReport->breakFastReportDelegates;
        $breakfastReportProducts = $breakfastReport->breakFastReportProducts;


        return view('breakfast.print',
            compact('breakfastReportDelegates', 'breakfastReportProducts', 'breakfastReport'));
    }

    public function destroy(BreakFastReport $breakFastReport)
    {
        $breakFastReport->delete();

        return redirect()->route('breakfast.index')->with('message', 'تم حذف التقرير بنجاح');
    }
}
