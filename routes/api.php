<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthsController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\DownloadsController;

Route::middleware(['cors'])->group(function () 
{
    Route::post('/login', [AuthsController::class, 'login']);

    //Route to all CRUD
    Route::apiresource('teacher', TeachersController::class);
    Route::apiresource('module',  ModulesController::class);
    Route::apiresource('student', StudentsController::class);

    //Route for services about student(s)
    Route::post('student/pass/{id}',        [ServicesController::class, 'pass']);
    Route::post('student/redouble/{id}',    [ServicesController::class, 'redouble']);
    Route::post('student/finish/{id}',      [ServicesController::class, 'finish_study']);
    Route::post('student/quit/{id}',        [ServicesController::class, 'quit']);
    Route::post('student/retake_exam/{id}', [ServicesController::class, 'retake_exam']);

    //Route for lists about students 
    Route::get('student/list/{grade}/{school_year}',               [ServicesController::class, 'get_student_by_grade']);
    Route::get('student/list/{grade}/{group}/{gender}/{school_year}',      [ServicesController::class, 'get_student_by_grade_and_gender']);        
    Route::post('student/list/quit',          [ServicesController::class, 'get_student_quitting']);      
    Route::post('student/list/retaking_exam', [ServicesController::class, 'get_student_retaking_exam']);        

    //Route to informations about marks of student(s)
    Route::post('mark',                                         [MarksController::class, 'store']);
    Route::get('student/all-marks/{year}/{id}',                     [MarksController::class, 'get_all_marks_by_year']);
    Route::get('student/average_point/{grade}/{year}/{id}',     [MarksController::class, 'get_average_point_of_student_by_grade']); 
    Route::get('student/average_point/{grade}/{year}',          [MarksController::class, 'get_average_point_of_all_students_by_grade']);     
    Route::get('student/general/average_point/{grade}/{year}',          [MarksController::class, 'get_general_average_point_of_all_students_by_grade']);     
    Route::get('student/general-average-point/{grade}',          [MarksController::class, 'get_general_average_point']);     
    Route::get('student/average_point/{gender}/{grade}/{year}', [MarksController::class, 'get_average_point_of_students_by_gender']);     

    //Route for other informations
    Route::get('module/list/{grade}',         [MarksController::class, 'list_module_by_grade']);
    Route::post('teacher/add/module/{id}',    [TeachersController::class, 'add_module']);
    Route::post('teacher/detach/module/{id}', [TeachersController::class, 'detach_module']);
    Route::get('download/pdf/{year}/{semester}/{id}', [DownloadsController::class, 'download_pdf_marks_students']);
    
    // protected routes
    Route::group(['middleware'=> 'auth:sanctum'],
    function () 
    {
        Route::post('/logout',   [AuthsController::class, 'logout']);
    });
});
