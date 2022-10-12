<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $teachers = Teacher::all();
        foreach($teachers as $teacher){
            $modules = $teacher->modules;
           $data[] = [
            "teacher" => $teacher,
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
            'name' =>'required'      ,
            'email' => 'required'    ,
            'diploma'=>'required'    ,
            // 'gender'=>'required'     ,
            'module_id' => 'required'
        ]
        );

        if ($request->hasFile('photo')) 
        {
            $filename = time() . '.' . $request-> photo ->extension();
            $request->file('photo')->move('img/teacher_pic/', $filename);
            $request->photo = $filename;
        }
       
        $teacher = Teacher::create($request->except('module_id'));  
        $module = Module::findOrFail($request->module_id);

        if($teacher->modules()->save($module))
        {
            return response()->json([
                'message' => 'success',
            ], 200);
        };
    }

    /**
     * Add module for the specified teacher
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add_module(Request $request ,int $id)
    {
        $request->validate([
            'module_id' => 'required'    ,
        ]);

        $teacher = Teacher::find($id)->first();
        $module = Module::findOrFail($request->module_id);
        $modules =  $teacher->modules;
        if($teacher->modules()->save($module))
        {
            return [
                'teacher' => $teacher,
            ];
        }
    }

     /**
     * detach a module for the specified teacher
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detach_module(Request $request ,int $id)
    {
        $request->validate([
            'module_id' => 'required|int'    ,
        ]);

        $teacher = Teacher::find($id)->first();
        $module = Module::findOrFail($request->module_id);

        if($teacher->modules()->detach($module))
        {
            return [
                'message' => 'success',
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        $teacher = Teacher::find($teacher)->first();
    
        $modules = $teacher->modules;
        return [
            'teacher' => $teacher,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' =>'required'      ,
            'email' => 'required'    ,
            'diploma'=>'required'    ,
            'gender'=>'required'     ,
        ]
        );
        $teacher = Teacher::find($id);	
        
        if ($request->hasFile('photo')) 
        {
            $destination = "img/teacher_pic/". $teacher->photo; 
            File::delete($destination); 

            $filename = time() . '.' . $request-> photo ->extension();
            $request->file('photo')->move('img/teacher_pic/', $filename);
            $request->photo = $filename;
        }

        if($teacher->update($request->all())){
            return [
                'message' => 'success'		,
            ];
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Teacher::destroy($id);
    }
}
