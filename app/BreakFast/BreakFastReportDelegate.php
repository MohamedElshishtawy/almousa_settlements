<?php

namespace App\BreakFast;

use App\Models\Delegate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakFastReportDelegate extends Model
{
    use HasFactory;

    protected $fillable = [
        'delegate_id', 'break_fast_report_id',
    ];


    public function delegate()
    {
        return $this->belongsTo(Delegate::class);
    }

    public function breakFastReport()
    {
        return $this->belongsTo(BreakFastReport::class);
    }
}
