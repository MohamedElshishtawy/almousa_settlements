<?php

namespace App\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurplusProductError extends Model
{
    use HasFactory;

    protected $fillable = [
        'surplus_id',
        'static_product_id',
    ];

    public function surplus()
    {
        return $this->belongsTo(Surplus::class);
    }

    public function static_product()
    {
        return $this->belongsTo(\App\Product\StaticProduct::class);
    }


}
