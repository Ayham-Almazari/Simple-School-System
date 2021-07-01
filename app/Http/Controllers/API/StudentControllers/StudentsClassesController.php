<?php

namespace App\Http\Controllers\API\StudentControllers;

use App\Exceptions\StudentExistsinClassroomBeforeException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassRoomResource;
use App\Http\Resources\TeacherResource;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentsClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return StudentResource
     */
    public function StudentClasses()
    {
        return  ClassRoomResource::collection(auth()->user()->Student_Classes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return StudentResource
     */
    public function StudentTeachers()
    {
        return  TeacherResource::collection(auth()->user()->Student_Teachers);
    }

    /**
     * Display a listing of the resource.
     *
     * @return StudentResource
     */
    public function StudentMaterials()
    {
        return  $this->returnData(auth()->user()->Materials);
    }


    /**
     * Display the specified resource.
     *
     * @param Student $student
     * @return \Illuminate\Http\Response
     * @throws StudentExistsinClassroomBeforeException
     */
    public function ClassTeacher(ClassRoom $classRoom)
    {
        //if the student is not belongs to the class
        if (!$classRoom->Class_Students->find(auth()->user()->id))
            throw new StudentExistsinClassroomBeforeException('Student Is Not Belongs To This Classroom .');

        return new TeacherResource($classRoom->Class_Teacher);
    }

    /**
     * Display the specified resource.
     *
     * @param Student $student
     * @return \Illuminate\Http\JsonResponse
     * @throws StudentExistsinClassroomBeforeException
     */
    public function StudentMarks(ClassRoom $classRoom)
    {
        //if the student is not belongs to the class
        if (!$classRoom->Class_Students->find(auth()->user()->id))
            throw new StudentExistsinClassroomBeforeException('Student Is Not Belongs To This Classroom .');
        return $this->returnData($classRoom->Class_Students->find(auth()->user()->id)->class->only(['first_term','mid_term','final_term']));
    }

}
