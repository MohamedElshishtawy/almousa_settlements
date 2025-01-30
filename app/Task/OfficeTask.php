<?php

namespace App\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeTask extends Model
{
    use HasFactory;

    protected $fillable = ['office_id', 'task_id'];

    protected $table = 'office_task';

    public function office()
    {
        return $this->belongsTo(\App\Office\Office::class);
    }

    public function task()
    {
        return $this->belongsTo(\App\Task\Task::class);
    }

}
