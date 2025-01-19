<?php

namespace App\Obligations;

use App\Models\Company;
use App\Office\Office;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obligations extends Model
{
    use HasFactory;
    protected $fillable = [
        'office_id',
        'company_id',
    ];

    public static $headers = [
        "تأمين بعض أنواع المواد ذات النوعية الرديئة أو غير المطابقة للشروط",
        "نقص في توريد مواد الطبخ",
        "نقص في توريد معدات الطبخ",
        "عدم تأمين الحلواني من بداية المهمة حتى تاريخ المحضر",
        "عدم توفير الشهادات الصحية لكل/بعض العمالة حتى تاريخ",
        "",
    ];


    public function bands()
    {
        return $this->hasMany(Bands::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
