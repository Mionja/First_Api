<?php

namespace App\Http\Controllers;

use App\Models\Mark;
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
        return['Quit'=>$grade->update([
            'quit' => 1
            ])];                            

    }

    /**
     * Mamerina nombre des etudiant dans une classe donnée en une année donnée
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_number_student_by_grade(Request $request)
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
                    'student'=>$grade->student      ,
                    'grade'=>[
                        'name'=>$grade->name                ,    
                        'school_year'=>$grade->school_year  ,
                        'group'=> $grade->group
                        ]           
                ];        
            }
        }
    
        return $students_with_specified_gender;
    }

    /**
     * Get list of all students having quitted in a specified grade and year
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $grade
     * @param  int $year
     * @return \Illuminate\Http\Response
     */
    public function get_student_quitting(Request $request, string $grade, int $year)
    {
        //The request can send a specified group of the students
        if ($request->group) 
        {
            $grades = Grade::all()->where('name', $grade)->where('group', $request->group)->where('school_year', $year)->where('quit', 1);    
        }
        else
        {
            $grades = Grade::all()->where('name', $grade)->where('school_year', $year)->where('quit', 1);
        }
        $students = [];
        foreach ($grades as $grade) 
        {
            $students[] = [
                'students'=> $grade->student
            ];
        }

        return $students;
    }

    public function get_student_retaking_exam(Request $request)
    {
        $request->validate([
            'grade' =>'required'          ,
            'school_year' => 'required'   ,
            // 'group' => 'required'      ,
        ]);

        if ($request->group) 
        {
            $grades = Grade::all()->where('name', $request->grade)->where('group', $request->group)->where('school_year', $request->school_year);    
        }
        else
        {
            $grades = Grade::all()->where('name', $request->grade)->where('school_year', $request->school_year);
        }

        $marks = Mark::all()->where('retake_exam', 1)->where(('created_at.year'), $request->school_year);

        $students = [];
        foreach ($grades as $grade) 
        {
            foreach ($marks as $mark) 
            {
                if ($mark->student_id == $grade->student_id) 
                {
                    $students[] = [
                        'student_id'=> $grade->student_id   ,
                        'mark'=> ['score'=>$mark->score, 
                                    'semester'=>$mark->semester, 
                                  'module'=>$mark->module]
                    ];
                }
            }
        }

        return $students;

    }
}
