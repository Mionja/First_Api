<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'age', 'gender', 'photo'];


     // Relationship with grades
     public function grades() 
     {
         return $this->hasMany(Grade::class, 'student_id');
     }

     // Relationship with marks
     public function marks() 
     {
        return $this->hasMany(Mark::class, 'student_id');
     }
}
