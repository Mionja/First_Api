<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'school_year', 'group', 'end', 'quit', 'student_id'];

     // Relationship with student
     public function student() 
     {
         return $this->belongsTo(Student::class, 'student_id');
     }

}
