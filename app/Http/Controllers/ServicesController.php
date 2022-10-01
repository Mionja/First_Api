<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    
    /**
     * Nifindra classe
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $id
     * @return \Illuminate\Http\Response
     */
    public function pass(Request $request, $id)
    {
        $request->validate([
            'grade' =>'required'          ,
            'school_year' => 'required'   ,
            'group' => 'required'         , //Here, you should put the new group of the student
        ]);
        if ($request->grade != 'M2') 
        {
            $student = Student::find($id);
            switch ($request->grade) {
                case 'L1':
                    $grade = 'L2';
                    break;
                case 'L2':
                    $grade = 'L3';
                    break;
                case 'L3':
                    $grade = 'M1';
                    break;
                case 'M1':
                    $grade = 'M2';
                    break;
            }
    
            return [
                'student' =>$student    ,
                'passed_grade'=> Grade::create([
                    'student_id' => $id            ,
                    'name' => $grade               ,
                    'group' => $request->group               ,
                    'school_year' => $request->school_year +1   ,
                ])
            ];
        }
        else 
        {
            $grade = Grade::all()->where('student_id', $id)
                                ->where('name', $request->grade)
                                ->where('school_year', $request->school_year)
                                ->first();
            return['grade'=>$grade->update([
                'end' => 1
            ])];     
        }

    }

    
    /**
     * Ni-Redouble
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $id
     * @return \Illuminate\Http\Response
     */
    public function redouble(Request $request, $id)
    {
        $request->validate([
            'grade' =>'required'          ,
            'group' =>'required'          ,
            'school_year' => 'required'   ,
        ]);

        return Grade::create([
            'student_id' => $id            ,
            'name' => $request->grade               ,
            'group' => $request->group               ,
            'school_year' => $request->school_year +1   ,
       ]);
    }

    /**
     * Vita fianarana
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $id
     * @return \Illuminate\Http\Response
     */
    public function finish_study(Request $request, $id)
    {
        $request->validate([
            'grade' =>'required'          ,
            'school_year' => 'required'   ,
        ]);
        $grade = Grade::all()->where('student_id', $id)
                            ->where('name', $request->grade)
                            ->where('school_year', $request->school_year)
                            ->first();
        return['grade'=>$grade->update([
            'end' => 1
        ])];     
    }

    /**
     * Niala fianarana
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $id
     * @return \Illuminate\Http\Response
     */
    public function quit(Request $request, $id)
    {
        $request->validate([
            'grade' =>'required'          ,
            'school_year' => 'required'   ,
        ]);
        $grade = Grade::all()->where('student_id', $id)
                            ->where('name', $request->grade)
                            ->where('school_year', $request->school_year)
                            ->first();
        return['grade'=>$grade->update([
            'quit' => 1
            ])];                            

    }

    /**
     * Mamerina nombre des etudiant dans une classe donnée en une année donnée
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_number_student_by_grade_of_year(Request $request)
    {
        $request->validate([
            'grade' =>'required'          ,
            'school_year' => 'required'   ,
        ]);

        $number_student = Grade::all()
                            ->where('name', $request->grade)
                            ->where('school_year', $request->school_year)
                            ->count();
        return $number_student;
    }

     /**
     * Mamerina etudiant(F/M) dans une classe donnée en une année donnée
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_student_by_grade_and_gender(Request $request)
    {
        $request->validate([
            'grade' =>'required'          ,
            'school_year' => 'required'   ,
            'gender' => 'required'        ,
        ]);

        $students_with_specified_gender = [];

        if ($request->group) 
        {
            $grades = Grade::all()->where('name', $request->grade)
                                  ->where('school_year', $request->school_year)
                                  ->where('group', $request->group)    ;    
        }
        else
        {
            $grades = Grade::all()->where('name', $request->grade)
                                  ->where('school_year', $request->school_year);
        }

        foreach ($grades as $grade) 
        {
            if ($grade->student->gender == $request->gender) 
            {
                $students_with_specified_gender[]=[
                    'student'=>$grade->student
                ];        
            }
        }
    
        return $students_with_specified_gender;
    }
}
