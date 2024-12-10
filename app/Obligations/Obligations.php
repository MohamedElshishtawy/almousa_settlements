<?php

namespace App\Obligations;

use App\Office\Office;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obligations extends Model
{
    use HasFactory;
    protected $fillable = [
        'office_id',
        'company_name',
    ];

    public function bands()
    {
        return $this->hasMany(Bands::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
