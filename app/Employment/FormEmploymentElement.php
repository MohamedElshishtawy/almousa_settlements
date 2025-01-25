<?php

namespace App\Employment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Employment\FormEmployment;

class FormEmploymentElement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'count',
        'benefits',
        'main_count',
        'form_employment_id',
    ];

    const CLEAN_STATUS = ['ممتاز', 'متوسط', 'سىء'];
    const HEALTH_STATUS = ['مكتملة', 'غير مكتملة'];
    const COUNT_STATUS = ['مكتملة', 'غير مكتملة'];


    public function fromEmployment()
    {
        return $this->belongsTo(FormEmployment::class);
    }

    public function getEmploymentRealCount($benefits, $count, $realBenefits)
    {
        return $benefits ? floor($count * $realBenefits /$benefits) : 0;
    }
}
