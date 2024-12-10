<?php

namespace App\Obligations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bands extends Model
{
    use HasFactory;

    protected $fillable = [
      'head',
      'description',
        'is_active',
        'obligation_id',
    ];

    public function obligations()
    {
        return $this->belongsTo(Obligations::class);
    }

}
