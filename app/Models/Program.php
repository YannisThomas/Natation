<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{

    protected $table = 'program';

    // Définition des colonnes que tu peux mass-assigner
    protected $fillable = [
        'titre',
        'description',
        'date_debut',
        'date_fin',
        'coach_id',
        'sportif_id',
    ];

    // Relation avec les exercices via une table pivot
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'exercise_program')
        ->withPivot(['sets', 'reps', 'duration'])
        ->withTimestamps();
}

    // Relation avec le coach
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');  // Un programme appartient à un coach
    }

    // Relation avec le sportif
    public function sportif()
    {
        return $this->belongsTo(User::class, 'sportif_id');  // Un programme appartient à un sportif
    }
}
