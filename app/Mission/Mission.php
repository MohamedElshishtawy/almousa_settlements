<?php

namespace App\Mission;

use App\Product\ProductLivingMission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
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
