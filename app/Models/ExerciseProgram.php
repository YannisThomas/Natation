<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseProgram extends Model
{
    protected $table = 'exercise_program';
    public $timestamps = false;
    protected $fillable = [
        'program_id',
        'exercise_id',
        'finished_at',
    ];
}
