<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\ServicesController;

Route::middleware(['cors'])->group(function () {

//Route to all CRUD
Route::apiresource('admin',   AdminsController::class);
Route::apiresource('teacher', TeachersController::class);
Route::apiresource('module',  ModulesController::class);
Route::apiresource('student', StudentsController::class);

//Route for services about student(s)
Route::post('student/pass/{id}', [ServicesController::class, 'pass']);
Route::post('student/redouble/{id}', [ServicesController::class, 'redouble']);
Route::post('student/finish/{id}', [ServicesController::class, 'finish_study']);
Route::post('student/quit/{id}', [ServicesController::class, 'quit']);
Route::post('student/retake_exam/{id}', [ServicesController::class, 'retake_exam']);


//Route for lists about students
Route::post('student/list/gender', [ServicesController::class, 'get_student_by_grade_and_gender']);        
Route::post('student/list/quit/{grade}/{year}', [ServicesController::class, 'get_student_quitting']);      
Route::post('student/list/retaking_exam', [ServicesController::class, 'get_student_retaking_exam']);        
Route::post('number/student', [ServicesController::class, 'get_number_student_by_grade']);

//Route to get informations about modules
Route::get('module/list/{grade}', [MarksController::class, 'list_module_by_grade']);

//Route to informations about marks of student(s)
Route::post('mark', [MarksController::class, 'store']);                                                                     //
Route::get('student/marks/{year}/{id}', [MarksController::class, 'get_all_marks_by_year']);
Route::get('student/average_point/{grade}/{year}/{id}', [MarksController::class, 'get_average_point_of_student_by_grade']); 
Route::get('student/average_point/{grade}/{year}', [MarksController::class, 'get_average_point_of_all_students_by_grade']);     
Route::get('student/average_point/{grade}/{year}/{gender}', [MarksController::class, 'get_average_point_of_students_by_gender']);     

});
