<?php

namespace App\Product;

use App\Report\ImportProductError;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticProduct extends Product
{
    use HasFactory;
    protected $table = 'static_products';

    protected $fillable = [
        'old_id',
        'name',
        'price',
        'daily_amount',
        'food_type_id',
        'food_unit_id',
    ];


    public function pdoductsDayMeal()
    {
        return $this->hasMany(ProductDayMeal::class);
    }

    public function importProductError()
    {
        return $this->hasOne(ImportProductError::class);
    }


}
