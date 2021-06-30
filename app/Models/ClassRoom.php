<?php

namespace App\Models;

use App\Models\Pivots\Classes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassRoom extends Model
{
    use HasFactory;

    protected $dateFormat = "Y-m-d H:i:s";
    protected $table = "classrooms";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $guarded = [

    ];

    public function Class_Teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class , "teacher_id");
    }

    public function Class_Students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'classes', 'classroom_id', 'student_id')
            ->using(Classes::class)
            ->as('class')
            ->withPivot('id as class_id', 'teaching_subject','first_term','mid_term','final_term')
            ->withTimestamps();
    }

    public function class_materials(array $attributes = [])
    {
        return $this->hasMany(ClassMaterials::class, "classroom_id");
    }
}
