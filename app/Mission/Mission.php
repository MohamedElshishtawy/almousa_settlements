<?php

namespace App\Mission;

use App\Product\ProductLivingMission;
use App\Product\ProductPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public static $missions = [
        'حج',
        'رمضان',
        'حج تجهيز',
        'رمضان تجهيز',
    ]; // [0,1] we are using indexes of these values

    public static function gettingReadyMissionsIds()
    {
        return Mission::whereIn('title', ['حج تجهيز', 'رمضان تجهيز'])->pluck('id')->toArray();
    }

    public static function gettingMainMissionsIds()
    {
        return Mission::whereIn('title', ['حج', 'رمضان'])->pluck('id')->toArray();
    }

    public static function syncMainWithReady($mainMissionId)
    {

        $syncTitle = [
            'حج' => 'حج تجهيز',
            'رمضان' => 'رمضان تجهيز',
        ];

        $mainMissionTitle = Mission::find($mainMissionId)->title;
        return Mission::where('title', $syncTitle[$mainMissionTitle])->first()->id;
    }

    public function productsLivingMission()
    {
        return $this->hasMany(ProductLivingMission::class);
    }

    public function officeMissions()
    {
        return $this->hasMany(\App\Office\OfficeMission::class);
    }

}
