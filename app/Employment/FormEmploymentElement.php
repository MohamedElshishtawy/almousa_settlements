<?php

namespace App\Employment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormEmploymentElement extends Model
{
    use HasFactory;

    const CLEAN_STATUS = ['ممتاز', 'متوسط', 'سىء'];
    const HEALTH_STATUS = ['مكتملة', 'غير مكتملة'];
    const COUNT_STATUS = ['مكتملة', 'غير مكتملة'];
    protected $fillable = [
        'title',
        'count',
        'benefits',
        'main_count',
        'form_employment_id',
    ];

    public function fromEmployment()
    {
        return $this->belongsTo(FormEmployment::class);
    }

    public function getEmploymentRealCount($benefits, $count, $realBenefits)
    {
        return $benefits ? ceil($count * $realBenefits / $benefits) * $count : 0;
    }


}
