<?php

namespace App\BreakFast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakFastReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'for_date', 'notes',
    ];

    public function breakFastReportProducts()
    {
        return $this->hasMany(BreakFastReportProduct::class);
    }

    public function breakFastReportDelegates()
    {
        return $this->hasMany(BreakFastReportDelegate::class);
    }
}
