<?php

namespace App\BreakFast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakFastReportProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'break_fast_product_id', 'break_fast_report_id', 'daily_amount', 'price',
    ];

    public function breakFastProduct()
    {
        return $this->belongsTo(BreakFastProduct::class);
    }

    public function breakFastReport()
    {
        return $this->belongsTo(BreakFastReport::class);
    }
}
