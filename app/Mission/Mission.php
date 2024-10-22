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

    public static $missions = ['حج', 'رمضان']; // [0,1] we are using indexes of these values

    public function productsLivingMission()
    {
        return $this->hasMany(ProductLivingMission::class);
    }
}
