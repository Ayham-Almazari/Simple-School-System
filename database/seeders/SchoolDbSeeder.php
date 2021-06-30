<?php

namespace Database\Seeders;

use App\Models\ClassMaterials;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class SchoolDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::factory(2)->create()->each(function($teacher){

            ClassRoom::factory(1)->create(['teacher_id'=>$teacher->id])->each(function ($class) use ($teacher) {
                Student::factory(3)->create()->each(function ($student)use($teacher,$class){
                    $teacher->Teacher_Students()->attach([$student->id],['classroom_id'=>$class->id]);
                });

                ClassMaterials::factory(2)->create(['classroom_id'=>$class->id]);
            });
        });
    }
}
