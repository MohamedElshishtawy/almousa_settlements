<?php

namespace App\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'note', 'user_id', 'office_id'];

    public function office()
    {
        return $this->belongsTo(\App\Office\Office::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function lastReadedHistories()
    {
        return $this->hasMany(LastReadedHistory::class);
    }

    public function getStageAttribute()
    {
        return $this->histories->last()->stage ?? null;
    }

}
