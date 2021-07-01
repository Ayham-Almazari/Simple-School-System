<?php

use App\Http\Controllers\API\StudentControllers\StudentsClassesController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:student')->prefix('student')->namespace('API\StudentControllers')->group(function () {
    Route::get('classrooms',[StudentsClassesController::class,'StudentClasses']);
    Route::get('teachers',[StudentsClassesController::class,'StudentTeachers']);
    Route::get('materials',[StudentsClassesController::class,'StudentMaterials']);
    Route::get('classrooms/{classroom}/teacher',[StudentsClassesController::class,'ClassTeacher']);
    Route::get('classrooms/{classroom}/marks',[StudentsClassesController::class,'StudentMarks']);

});
