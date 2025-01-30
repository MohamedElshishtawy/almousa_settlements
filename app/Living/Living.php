<?php

namespace App\Living;

use App\Employment\Employment;
use App\Office\Office;
use App\Product\ProductLivingMission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Living extends Model
{
    use HasFactory;

    public static $livings = ['قيادة', 'ميدان'];
    protected $fillable = [
        'title',
    ];

    public function productsLivingMission()
    {
        return $this->hasMany(ProductLivingMission::class);
    }

    public function office()
    {
        return $this->hasMany(Office::class);
    }

    public function employments()
    {
        return $this->hasMany(Employment::class);
    }
}
