<?php

namespace App\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluateElement extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function userEvaluates()
    {
        return $this->hasMany(UserEvaluate::class);
    }

}
