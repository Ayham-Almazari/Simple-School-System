<?php

namespace App\Http\Controllers\API\TeacherControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\MaterialResource;
use Illuminate\Http\Request;

class TeacherClassMaterials extends Controller
{
    private mixed $Teacher;
    private $Teacher_classes_property;
    private $Teacher_classes_relational;
    private $Teacher_material_property;
    private $Teacher_material_relational;

    public function __construct()
    {
        $this->Teacher = auth('teacher')->user();
        if($this->Teacher):
            @$this->Teacher_classes_property = $this->Teacher->Teacher_classes;
            @$this->Teacher_classes_relational = $this->Teacher->Teacher_classes();
            @$this->Teacher_material_property = $this->Teacher->Materials;
            @$this->Teacher_material_relational = $this->Teacher->Materials();
        endif;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MaterialResource::collection($this->Teacher_material_property);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $path =  $request->file('file')->store('TracherMaterials' , "public");
      return $path;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
