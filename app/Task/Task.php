<?php

namespace App\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public static $states = ['لم يبدأ', 'تم إنجازها', 'توفر الى حد ما'];
    protected $fillable = ['title', 'state', 'notes', 'office_id'];

    public function office()
    {
        return $this->belongsTo(\App\Office\Office::class);
    }

    public function offices()
    {
        return $this->belongsToMany(\App\Office\Office::class)->using(\App\Task\OfficeTask::class);
    }


}
