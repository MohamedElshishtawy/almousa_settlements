<?php

namespace App\Task;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'task_histories';

    protected $fillable = [
        'task_id',
        'stage_id',
        'user_id',
        'note',
        'description',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
