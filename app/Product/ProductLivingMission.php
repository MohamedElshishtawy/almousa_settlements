<?php

namespace App\Product;

use App\Living\Living;
use App\Mission\Mission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLivingMission extends Model
{
    use HasFactory;

    protected $table = 'products_living_mission';

    protected $fillable = [
        'product_id',
        'living_id',
        'mission_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function living()
    {
        return $this->belongsTo(Living::class);
    }

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }
}
