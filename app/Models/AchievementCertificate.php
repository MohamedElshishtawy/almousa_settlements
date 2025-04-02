<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id', // علاقة العقد
        'achievements_per',
        'def',
        'not_achievements',
    ];

    // علاقة العقد
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

}
