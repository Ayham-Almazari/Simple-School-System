<?php

namespace App\Http\Controllers\API\TeacherControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateClassMaterial;
use App\Http\Resources\MaterialResource;
use App\Models\ClassRoom;
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

    public function getRelationalMaterial($ClassroomID){
          return $this->Teacher_classes_property->find($ClassroomID)->class_materials();
    }
    public function getRelationalProperty($ClassroomID){
          return $this->Teacher_classes_property->find($ClassroomID)->class_materials;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClassRoom $classRoom)
    {
        return MaterialResource::collection($this->getRelationalProperty($classRoom->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClassMaterial $request,ClassRoom $classRoom)
    {
        try {
            if($request->file('file')):
                get_file_name:{
                $file = $request->file('file');
                //get name of file
                $fileName = $file->getClientOriginalName();
                //strip out all spaces
                $fileName = str_replace(' ', '',$fileName);
            }
                create_material_to_get_id_to_be_file_name:{
                $new_material=  $this->getRelationalMaterial($classRoom->id)->create($request->only('material_description'));
            }
                Store_material_in_storage_And_database:{
                $path =  $file->storeAs('TreacheryMaterials/'.$new_material->id , $fileName,"public");
                if (!$path){
                    $new_material->delete();
                    return $this->returnErrorMessage('File Error Uploading .');
                }
                $new_material->update(['material'=>$path]);
            }
            endif;
        }catch (\Exception $e){
                //TODO MAKE CUSTOM EXEPTION
        }
        response:
        return $this->returnSuccessMessage("Material Added To Class {$classRoom->class_name} Successfully .");
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
