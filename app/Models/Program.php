<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'user_id',
        'coach_id',
    ];

    use HasFactory;

    public $timestamps = false;

    // Relation avec l'athlète qui suit ce programme
    public function athlete()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec le coach qui a créé ce programme
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    // Relation avec les exercices du programme
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }
}
