<?php

namespace App\Report;

use App\Employment\FormEmployment;
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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($import) {
            activity()
                ->performedOn($import)
                ->causedBy(auth()->user())
                ->withProperties(['import_id' => $import->id])
                ->log('تم حفظ محضر توريد');
        });

        static::updated(function ($import) {
            activity()
                ->performedOn($import)
                ->causedBy(auth()->user())
                ->withProperties([
                    'old_data' => $import->getOriginal(),
                    'new_data' => $import->getChanges(),
                ])
                ->log('تم تعديل محضر توريد');
        });

        static::deleting(function ($import) {
            activity()
                ->performedOn($import)
                ->causedBy(auth()->user())
                ->withProperties([
                    'old_data' => $import->getOriginal(),
                ])
                ->log('تم حذف محضر توريد');
            $import->importProductError()->delete();
        });
    }


    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function importProductError()
    {
        return $this->hasMany(ImportProductError::class);
    }

    public function formEmployment()
    {
        return $this->hasOne(FormEmployment::class);
    }


    public function isDiffrence()
    {
        $productErrors = $this->importProductError;
        $staticProducts = $this->report->staticProducts;
        foreach ($productErrors as $productError) {
            $staticProduct = $staticProducts->where('id', $productError->static_product_id)->first();
            if ($staticProduct->daily_amount * $this->benefits != $productError->error) {
                return true;
            }
        }
        return false;
    }

    public function getBenefits()
    {
        return $this->benefits - $this->benefits_error;
    }
}
