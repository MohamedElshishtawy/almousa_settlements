<?php

namespace App\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvaluate extends Model
{
    use HasFactory;

    protected $fillable = ['evaluator_id', 'evaluated_id', 'evaluation_id', 'evaluate_week_id', 'evaluate_element_id'];

    public function evaluator()
    {
        return $this->belongsTo(\App\Models\User::class, 'evaluator_id');
    }

    public function evaluated()
    {
        return $this->belongsTo(\App\Models\User::class, 'evaluated_id');
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function evaluateWeek()
    {
        return $this->belongsTo(EvaluateWeek::class);
    }


}
