<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelayPenalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id', // علاقة العقد
        'amount',
        'percentage',
    ];

    // علاقة العقد
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
