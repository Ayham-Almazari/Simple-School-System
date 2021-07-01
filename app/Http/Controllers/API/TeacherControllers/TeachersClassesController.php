<?php

namespace App\Http\Controllers\API\TeacherControllers;

use App\Exceptions\CreateClassRoomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateClassRoomRequest;
use App\Http\Resources\ClassRoomResource;
use App\Models\ClassRoom;
use Exception;
use Gate;
use Illuminate\Http\JsonResponse;

class TeachersClassesController extends Controller
{
    protected mixed $Teacher;
    protected $Teacher_classes_property;
    protected $Teacher_classes_relational;

    public function __construct()
    {
        $this->Teacher = auth('teacher')->user();
       /* @$this->Teacher_classes_property = $this->Teacher->Teacher_classes;
        @$this->Teacher_classes_relational = $this->Teacher->Teacher_classes();*/
    }

    /**
     * Display a listing of the ClassRooms.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ClassRoomResource::collection($this->Teacher_classes_property);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateClassRoomRequest $request
     * @return JsonResponse
     */
    public function store(CreateClassRoomRequest $request)
    {
        try {
            $this->Teacher_classes_relational->create($request->only(['class_name', 'class_description']));
            return $this->returnSuccessMessage('Classroom Created Successfully .', 201);
        } catch (Exception $e) {
            throw new CreateClassRoomException('Classroom Not Created .');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param ClassRoom $classRoom
     * @return ClassRoomResource
     */
    public function show(ClassRoom $classRoom)
    {
        $response = Gate::inspect('authorize_classroom_for_owner_teacher', [ClassRoom::class, $classRoom]);
        if ($response->denied())
            return $this->returnErrorMessage($response->message());
        return new ClassRoomResource($classRoom);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param CreateClassRoomRequest $request
     * @param ClassRoom $classRoom
     * @return Response
     */
    public function update(CreateClassRoomRequest $request, ClassRoom $classRoom)
    {
        $response = Gate::inspect('authorize_classroom_for_owner_teacher', [ClassRoom::class, $classRoom]);
        if ($response->denied())
            return $this->returnErrorMessage($response->message());
        try {
            $classRoom->update($request->only(['class_name', 'class_description']));
            return $this->returnSuccessMessage('Classroom Updated Successfully .', 201);
        } catch (Exception $e) {
            throw new CreateClassRoomException('Classroom Not Updated .');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ClassRoom $classRoom
     * @return JsonResponse
     * @throws CreateClassRoomException
     */
    public function destroy(ClassRoom $classRoom)
    {
        $response = Gate::inspect('authorize_classroom_for_owner_teacher', [ClassRoom::class, $classRoom]);
        if ($response->denied())
            return $this->returnErrorMessage($response->message());
        try {
            $classRoom->delete();
            return $this->returnSuccessMessage('Classroom deleted Successfully .', 200);
        } catch (Exception $e) {
            throw new CreateClassRoomException('Classroom Not deleted .');
        }
    }
}
