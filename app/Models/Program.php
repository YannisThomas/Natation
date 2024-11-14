<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{

    use HasFactory;
    public $timestamps = false;
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }
}
