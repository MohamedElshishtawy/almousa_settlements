<?php

namespace App\Product;

use App\Models\Day;
use App\Office\Office;
use App\Office\OfficeMission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'food_type_id',
        'food_unit_id',
    ];

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }

    public function foodUnit()
    {
        return $this->belongsTo(FoodUnit::class);
    }

    public function productsLivingMission()
    {
        return $this->hasMany(ProductLivingMission::class);
    }

    public static function getProductMissionData(Product $product, Office $office,  OfficeMission $officeMission)
    {
        return $product->productsLivingMission->where('living_id', $office->living_id)->where('mission_id', $officeMission->mission_id)->first();
    }

}
