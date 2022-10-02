<?php

namespace App\Models;

use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'diploma', 'photo'];

     // Relationship with modules
     public function modules() 
     {
        return $this->belongsToMany(Module::class);
     }
}
