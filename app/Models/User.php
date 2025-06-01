<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lastname',
        'firstname',
        'role_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relation avec le rôle de l'utilisateur
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Programmes attribués à cet utilisateur (quand il est athlète)
     */
    public function programs()
    {
        return $this->hasMany(Program::class, 'user_id');
    }

    /**
     * Programmes créés par cet utilisateur (quand il est coach)
     */
    public function createdPrograms()
    {
        return $this->hasMany(Program::class, 'coach_id');
    }

    /**
     * Récupère les athlètes de ce coach (via les programmes)
     */
    public function athletes()
    {
        return User::whereIn('id', $this->createdPrograms()->pluck('user_id')->unique());
    }

    /**
     * Récupère les coachs de cet athlète (via les programmes)
     */
    public function coaches()
    {
        return User::whereIn('id', $this->programs()->pluck('coach_id')->unique());
    }

    /**
     * Vérifie si l'utilisateur est un admin
     */
    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est un coach
     */
    public function isCoach()
    {
        return $this->role->name === 'coach' || $this->isAdmin();
    }

    /**
     * Vérifie si l'utilisateur est un athlète
     */
    public function isAthlete()
    {
        return $this->role->name === 'sportif' || $this->isAdmin();
    }
}
