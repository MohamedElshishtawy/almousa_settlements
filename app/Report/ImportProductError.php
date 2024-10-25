<?php

namespace App\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportProductError extends Model
{
    use HasFactory;

    protected $fillable = [
        'import_id',
        'static_product_id',
        'error',
    ];

    public function import()
    {
        return $this->belongsTo(Import::class);
    }

    public function staticProduct()
    {
        return $this->belongsTo(\App\Product\StaticProduct::class);
    }
}
