<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Les attributs mass assignables
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
        'role_id',
        'coach_id',
        'email_verified_at', // ✅ ajoute cette ligne
    ];

    // Les attributs à cacher
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Les attributs qui doivent être castés
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relation avec le rôle
    public function role()
    {
        return $this->belongsTo(Role::class);  // ✅ Relation avec la table `roles`
    }

    // Relation avec le coach (si l'utilisateur est un sportif)
    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
    public function sportifs()
    {
        return $this->hasMany(User::class, 'coach_id');  // Le coach a plusieurs sportifs
    }
    public function programs()
{
    return $this->hasMany(Program::class, 'sportif_id'); // Associe le sportif avec le programme
}

    
}