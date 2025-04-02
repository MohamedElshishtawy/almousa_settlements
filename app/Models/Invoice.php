<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id', // علاقة العقد
        'invoice_number',
        'invoice_date',
        'delivery_date',
        'quantity',
        'total_amount',
        'net_amount',
        'tax_amount',
        'delay_penalty',
        'electricity_bill',
        'alternative_insurance',
    ];

    // علاقة العقد
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
