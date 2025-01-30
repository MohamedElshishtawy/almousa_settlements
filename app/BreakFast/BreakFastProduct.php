<?php namespace App\BreakFast;


use App\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakFastProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'daily_amount', 'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function breakFastReports()
    {
        return $this->hasMany(BreakFastReport::class);
    }


}
