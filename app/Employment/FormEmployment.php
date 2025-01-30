<?php

namespace App\Employment;

use App\Report\Import;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormEmployment extends Model
{
    use HasFactory;

    protected $fillable = [
        'count_state',
        'cleaning_state',
        'health_state',
        'import_id'
    ];

    public function formEmploymentElements(): HasMany
    {
        return $this->hasMany(FormEmploymentElement::class);
    }

    public function import()
    {
        return $this->belongsTo(Import::class);
    }


}
