<?php

namespace App\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastReadedHistory extends Model
{
    use HasFactory;

    protected $table = 'task_last_readed_histories';

    protected $fillable = [
        'user_id',
        'task_id',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
