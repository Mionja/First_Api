<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mark extends Model
{
    use HasFactory;
    protected $fillable = [  'score','semester','year', 'module_id', 'student_id', 'retake_exam'];

     // Relationship with modules
     public function module() 
     {
        return $this->belongsTo(Module::class, 'module_id');
     }

     // Relationship with students
     public function students() 
     {
        return $this->belongsTo(Student::class, 'student_id');
     }
}
