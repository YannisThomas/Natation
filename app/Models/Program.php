<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'user_id',
    ];
    use HasFactory;
    public $timestamps = false;
    public function exercises()
    {

        return $this->belongsToMany(Exercise::class);
    }
}
