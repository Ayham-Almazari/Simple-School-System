<?php

namespace App\Models\Pivots;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Classes extends  Pivot
{
    use HasFactory;

    protected $table="classes";
    protected $dateFormat="Y-m-d H:i:s";
    protected $guarded=[];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s'
];
    protected $hidden=[
    "created_at",
    "updated_at"
];
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    //relations ----------------------------------------start--------------------------------------------
   function Students() {
        return $this->hasMany(Student::class,'student_id');
    }



}
