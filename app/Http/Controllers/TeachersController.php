<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Teacher;
use Illuminate\Http\Request;

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
           $data[] = [
            "teacher" => $teacher,
            "modules" => $teacher->modules,
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
            'module_id' => 'required'
        ]
        );
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        $teacher = Teacher::find($teacher)->first();
    
        return [
            'teacher' => $teacher,
            'modules' => $teacher->modules
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
        $teacher = Teacher::find($id);	
        

        if($request->module_id)
        {
            $module = Module::findOrFail($request->module_id);

            $teacher->modules()->update($module);
            $teacher->update($request->except('module_id'));
        }
        else
        {
            $teacher->update($request->all());
        }

        return [
            'message' => 'success'		,
        ];
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
