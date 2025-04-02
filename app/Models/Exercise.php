<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'exercise';

    protected $fillable = [
        'name',
        'duration',
        'description',
        'type',
        'weight',
        'distance',
        'repetition'
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'exercise_program')
                    ->withPivot(['sets', 'reps', 'duration'])
                    ->withTimestamps();
    }
}
