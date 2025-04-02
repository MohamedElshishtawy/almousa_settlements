<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contract_id', // علاقة العقد
        'number',
        'percentage',
        'cost_per_day',
        'days',
    ];

    // علاقة العقد
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
