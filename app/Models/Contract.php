<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number', // الرقم المرجعي
        'company_name',     // اسم الشركة
        'project_name',     // اسم المشروع
        'start_date',       // تاريخ البدء
        'end_date',         // تاريخ الانتهاء
        'contract_amount_without_tax', // مبلغ العقد شامل الضريبة
        'extension_period', // فترة التمديد
        'extended_amount_without_tax', // مبلغ المعد شامل الضريبة
        'note',             // ملاحظات
        'tax_percentage',  // نسبة الضريبة
        'commission_date',  // تاريخ التعميد
        'award_date',       // تاريخ استلام التعميد
        'contract_signing_date', // تاريخ ابرام العقد
        'deduction_ratio', // نسبة الإستقطاع
        'modified_tax', // الضريبة المعدلة
        'contract_type_id', // نوع العقد
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'commission_date' => 'date',
        'award_date' => 'date',
        'contract_signing_date' => 'date',
    ];

    // Accessors for derived attributes
    public function getDurationAttribute()
    {
        if ($this->start_date && $this->end_date) {
            $startDate = Carbon::parse($this->start_date);
            $endDate = Carbon::parse($this->end_date);

            Carbon::setLocale('ar');

            return $startDate->diffForHumans($endDate);
        }

        return null;
    }

    public function getCostWithTaxAttribute()
    {
        if ($this->contract_amount_without_tax && $this->tax) {
            return $this->contract_amount_with_tax + $this->tax;
        }
        return null;
    }

    public function getTaxAttribute()
    {
        if ($this->modefied_tax) {
            return $this->modefied_tax;
        }

        if ($this->contract_amount_without_tax && $this->tax_percentage) {
            return $this->contract_amount_without_tax * ($this->delay_percentage / 100);
        }
        return null;
    }

    public function getExtendCostWithTaxAttribute()
    {
        if ($this->extended_amount_with_tax && $this->extend_tax) {
            return $this->extended_amount_without_tax + $this->extend_tax;
        }
        return null;
    }

    public function getExtendTaxAttribute()
    {
        if ($this->extended_amount_without_tax && $this->tax_percentage) {
            return $this->extended_amount_with_tax * ($this->tax_percentage / 100);
        }
        return null;
    }

    // علاقة نوع العقد
    public function contractType()
    {
        return $this->belongsTo(ContractType::class);
    }

    // علاقة المستخلصات
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // علاقة غرامات التأخير
    public function delayPenalties()
    {
        return $this->hasMany(DelayPenalty::class);
    }

    // علاقة مدة نسبة التأخير
    public function delayPercentageDuration()
    {
        return $this->belongsTo(DelayPercentageDuration::class);
    }

    // علاقة حسم الأجار
    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }
}
