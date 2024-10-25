<?php

namespace App\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['office_id', 'for_date'];

    public function office()
    {
        return $this->belongsTo(\App\Office\Office::class);
    }

    public function import()
    {
        return $this->hasOne(Import::class);
    }
}
