<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Teacher;
use Illuminate\Http\Request;


class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $modules = Module::all();
        foreach($modules as $module){
            $teachers = $module->teachers;
           $data[] = [
            "module" => $module,
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
            'name' =>'required'           ,
            'code' => 'required|min:8|unique:modules,code'    ,
            'hour'=>'required'            ,
        ]
        );
        if ($request->teacher_id) 
        {
            $module = Module::create($request->except('teacher_id'));  
            $teacher = Teacher::findOrFail($request->teacher_id);
    
            $module_insert = $module->teachers()->save($teacher);
        }
        else
        {
            $module_insert = Module::create($request->all());
        }
        
        if ($module_insert)
        {
            return response()->json([
                'message' => 'success',
                'module'    => $module_insert
            ], 200);
        };   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        $module = Module::find($module)->first();
        $teachers = $module->teachers;
        return [
            'module' => $module        ,
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
        $module = Module::find($id);	
        if ($module->update($request->all())) {
            return [
                'message' => 'update success'		,
                'module'  =>  $module
            ];   
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Module::destroy($id);   
    }

  
}
