<?php

namespace App\Report;

use App\Models\Day;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurplusProductError extends Model
{
    use HasFactory;

    protected $fillable = [
        'surplus_id',
        'static_product_id',
        'surplus_benefits',
        'surplus_amount',
    ];

    public function surplus()
    {
        return $this->belongsTo(Surplus::class);
    }

    public function static_product()
    {
        return $this->belongsTo(\App\Product\StaticProduct::class);
    }

    /* will get the surplus for the day if null */
    public function getSurplus()
    {
        $surplusFoodType = $this->surplus->surplusFoodTypes ? $this->surplus->surplusFoodTypes->where('food_type_id',
            $this->static_product->food_type_id)->first() : null;

        return $this->surplus_amount || $this->surplus_benefits ?
            $this->surplus_amount + ($this->surplus_benefits * $this->static_product->daily_amount / $this->static_product->getHowManyPerDay(Day::date2object($this->surplus->report->for_date))) :
            ($surplusFoodType ? $surplusFoodType->value * $this->static_product->daily_amount : 0);
    }


}
