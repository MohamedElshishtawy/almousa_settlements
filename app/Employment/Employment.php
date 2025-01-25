<?php

namespace App\Employment;

use App\Living\Living;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Monolog\Level;

class Employment extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'benefits',
        'count',
        'living_id',
    ];

    public function living()
    {
        return $this->belongsTo(Living::class);
    }

    public function getEmploymentRealCount($benefits)
    {
        return (new FormEmploymentElement)->getEmploymentRealCount($this->benefits, $this->count, $benefits);
    }

}
