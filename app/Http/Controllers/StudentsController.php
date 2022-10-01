<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $module = [];
        $students = Student::all();
        foreach($students as $student){
            foreach ($student->marks as $mark) {
                $module[] = [
                            'code' => $mark->module->code,
                            'name' => $mark->module->name
                         ];
            }
            $grade = $student->grades;
            $data[] = [
             "student" => $student,
             
            ];
         }
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required'     ,
            'email' => 'required'   ,
            'gender'=>'required'    ,
            'age'=>'required'       ,
            'grade' =>'required'    ,
            'group' =>'required'    ,
            'school_year' =>'required'       ,
        ]);
        $student = Student::create($request->except(['grade', 'school_year', 'group']));
        $grade = Grade::create([
             'student_id' => $student->id            ,
             'name' => $request->grade               ,
             'group' => $request->grade               ,
             'school_year' => $request->school_year  ,
        ]);
        return [
                'student'=> $student    ,
                'grade'=> $grade    ,
            ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $student = Student::find($student)->first();
        $module = [];
        foreach ($student->marks as $mark) {
            $module[] = [
                        'code' => $mark->module->code,
                        'name' => $mark->module->name
                     ];
        }
        $grade = $student->grades;
        return [
            'student'=> $student           ,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' =>'required'     ,
            'email' => 'required'   ,
            'gender'=>'required'    ,
            'age'=>'required'       ,
        ]);
        $student = Student::find($student);
        
        $student->update($request->all());
        return $student;
    }

    /**
     * Remove everything about the specified student
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $grade = Grade::all()->where('student_id', $student->id);
        if (Grade::destroy($grade) && Student::destroy($student->id)) 
        {
            return ['message' => 'student deleted successfully'];   
        }
        else {
            return ['message' => 'failed to delete'];   
        }
    }
}
