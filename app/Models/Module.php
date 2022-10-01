<?php

namespace App\Models;

use App\Models\Mark;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'hour'];

    // Relationship with marks
    public function marks() 
    {
       return $this->hasMany(Mark::class, 'module_id');
    }


    //Relationship with teacher
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }
}
