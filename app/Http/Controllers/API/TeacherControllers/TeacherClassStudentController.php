<?php

namespace App\Http\Controllers\API\TeacherControllers;

use App\Exceptions\{CreateClassRoomException,
    EmptyClassroomException,
    StudentExistsinClassroomBeforeException
};
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\{ClassRoom, Student};
use Exception;
use Gate;
use Illuminate\Http\Request;

class TeacherClassStudentController extends Controller
{
    protected mixed $Teacher;
    private $Teacher_student_relational;

    public function __construct()
    {
       /* $this->Teacher = auth('teacher')->user();
        @$this->Teacher_student_relational = $this->Teacher->Teacher_Students();*/
    }

    /**
     * Display a listing of the ClassRooms.
     *
     * @return AnonymousResourceCollection
     */
    public function index(ClassRoom $classRoom)
    {
        //authorize
        $response = Gate::inspect('authorize_classroom_for_owner_teacher', [ClassRoom::class, $classRoom]);
        if ($response->denied())
            return $this->returnErrorMessage($response->message());
        return StudentResource::collection($classRoom->Class_Students()->orderBy("id", "asc")->get());
    }


    /**
     * Store a newly add student to a class.
     *
     * @return JsonResponse
     * @throws StudentExistsinClassroomBeforeException
     */
    public function store(ClassRoom $classRoom, Student $student)
    {
        //authorize
        $response = Gate::inspect('authorize_classroom_for_owner_teacher', [ClassRoom::class, $classRoom]);
        if ($response->denied())
            return $this->returnErrorMessage($response->message());
        //if student exists in classroom
        if ($classRoom->Class_Students->find($student->id))
            throw new StudentExistsinClassroomBeforeException('Student Is Already Added .');
        try {
            $this->Teacher_student_relational->attach($student->id, ['classRoom_id' => $classRoom->id]);
            return $this->returnSuccessMessage("Student {$student->name} Added to {$classRoom->class_name} Classroom Successfully .", 201);
        } catch (Exception $e) {
            throw new CreateClassRoomException('failed to add student to the class .');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param ClassRoom $classRoom
     * @return StudentResource
     */
    public function show(ClassRoom $classRoom, Student $student)
    {
        //authorization
        $response = Gate::inspect('authorize_classroom_for_owner_teacher', [ClassRoom::class, $classRoom]);
        if ($response->denied())
            return $this->returnErrorMessage($response->message());
        return new StudentResource($classRoom->Class_Students->find($student->id));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ClassRoom $classRoom
     * @return JsonResponse
     * @throws EmptyClassroomException
     * @throws StudentExistsinClassroomBeforeException
     * @throws CreateClassRoomException
     */
    public function update(Request $request, ClassRoom $classRoom, Student $student)
    {//Todo delete teaching subject from classes table and edit the pivots relations
        //validation
        $request->validate(['first_term' => "nullable|numeric", 'mid_term' => "nullable|numeric", 'final_term' => "nullable|numeric"]);
        //authorization
        $response = Gate::inspect('authorize_classroom_for_owner_teacher', [ClassRoom::class, $classRoom]);
        if ($response->denied())
            return $this->returnErrorMessage($response->message());
        //if the student is not belongs to the class
        if ($classRoom->Class_Students->count() === 0)
            throw new EmptyClassroomException('This Classroom Is Empty.');
        //if the student is not belongs to the class
        if (!$classRoom->Class_Students->find($student->id))
            throw new StudentExistsinClassroomBeforeException('Student Is Not Belongs To This Classroom .');
        //edit marks
        try {
            $classRoom->Class_Students()->updateExistingPivot($student->id, $request->only(['first_term', 'mid_term', 'final_term']));
            return $this->returnSuccessMessage('Student Class marks Updated Successfully .', 201);
        } catch (Exception $e) {
            throw new CreateClassRoomException('Student Class marks Updated Failed.');
        }
    }

    /**
     * Remove student from class.
     *
     * @param ClassRoom $classRoom
     * @return JsonResponse
     * @throws CreateClassRoomException
     */
    public function destroy(ClassRoom $classRoom, Student $student)
    {
        $response = Gate::inspect('authorize_classroom_for_owner_teacher', [ClassRoom::class, $classRoom]);
        if ($response->denied())
            return $this->returnErrorMessage($response->message());
        try {
            $this->Teacher_student_relational->detach($student->id);
            return $this->returnSuccessMessage('Student Removed From ClassRoom Successfully .', 200);
        } catch (Exception $e) {
            throw new CreateClassRoomException('Student remove from Classroom failed.');
        }
    }
}
