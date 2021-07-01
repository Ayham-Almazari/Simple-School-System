<?php

namespace App\Http\Controllers\API\TeacherControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassRoomResource;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TeachersController extends Controller
{
    private  $Teacher;
    private $Teacher_classes;

    public function __construct()
    {
        $this->Teacher = auth('teacher')->user();
        $this->Teacher_classes = $this->Teacher->Teacher_classes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ClassRoomResource::collection($this->Teacher_classes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Teacher $teacher
     * @return Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Teacher $teacher
     * @return Response
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Teacher $teacher
     * @return Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Teacher $teacher
     * @return Response
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
}
