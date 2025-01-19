<?php

namespace App\Living;

use App\Office\Office;
use App\Product\ProductLivingMission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Living extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public static $livings = ['قيادة', 'ميدان'];

    public function productsLivingMission()
    {
        return $this->hasMany(ProductLivingMission::class);
    }

    public function office()
    {
        return $this->hasMany(Office::class);
    }
}
