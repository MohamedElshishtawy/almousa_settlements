<?php

namespace App\Models;

use App\Obligations\Obligations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'delegate_name',
        'delegate_rank',
        'delegate_phone',
        'is_active',
    ];

    public function obligations(): HasMany
    {
        return $this->hasMany(Obligations::class);
    }

    public static function CompanyOfTheSeason(): Company
    {
        return Company::where('is_active' , true)->first() ?: Company::create([
            'name' => 'شركة عام' . now()->year,
            'date' => now()->format('Y-m-d'),
            'delegate_name' => 'ممثل الشركة',
            'delegate_rank' => 'مدير',
            'delegate_phone' => '01000000000',
            'is_active' => true,
        ]);
    }
}
