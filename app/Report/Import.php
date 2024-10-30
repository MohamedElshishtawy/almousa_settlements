<?php

namespace App\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $fillable = [
        'benefits',
        'benefits_error',
        'report_id',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function importProductError()
    {
        return $this->hasMany(ImportProductError::class);
    }
}
