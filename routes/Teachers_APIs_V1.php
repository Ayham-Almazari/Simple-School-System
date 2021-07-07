<?php

use App\Http\Controllers\API\TeacherControllers\TeacherClassStudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:teacher')->prefix('teacher')->namespace('API\TeacherControllers')->group(function () {
Route::apiResource('classrooms', TeachersClassesController::class);
Route::get('students/classrooms/{classroom}', [TeacherClassStudentController::class,'index']);
Route::get('search/not_in/class/{id}/students/{name?}', [TeacherClassStudentController::class,'AllStudents']);
Route::get('add/classrooms/{classroom}/students/{student}',[TeacherClassStudentController::class,'store']);
Route::put('update/classrooms/{classroom}/students/{student}/marks',[TeacherClassStudentController::class,'update']);
Route::get('classrooms/{classroom}/students/{student}',[TeacherClassStudentController::class,'show']);
Route::delete('classrooms/{classroom}/students/{student}',[TeacherClassStudentController::class,'destroy']);
//    http://127.0.0.1:8000/api/v1/teacher/classes/${this.$route.params.classroom}/materials
Route::get('classrooms/{classroom}/materials', [\App\Http\Controllers\API\TeacherControllers\TeacherClassMaterials::class,'index']);
Route::apiResource('classrooms/{classroom}/materials', TeacherClassMaterials::class)->except('index');

});
