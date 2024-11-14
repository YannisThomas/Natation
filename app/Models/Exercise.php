<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{


    use HasFactory;
    public $timestamps = false;
    protected $fillable =
    [
        'name',
        'duration',
        'description',
        'weight',
        'distance',
        'repetition',
        'category_id',
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
