<?php

namespace App\Living;

use App\Product\ProductLivingMission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Living extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function productsLivingMission()
    {
        return $this->hasMany(ProductLivingMission::class);
    }
}
