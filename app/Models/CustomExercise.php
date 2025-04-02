<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomExercise extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'duration', 'repetition', 'series'];

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'exercise_program')->withPivot(['duration', 'repetition', 'series']);
    }
}
