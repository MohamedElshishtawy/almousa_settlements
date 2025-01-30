<?php

namespace App\Models;

use App\Office\Office;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeOffice extends Model
{
    use HasFactory;

    protected $table = 'employee_offices';

    protected $fillable = [
        'user_id',
        'office_id',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
