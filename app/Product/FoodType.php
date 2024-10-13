<?php

namespace App\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
