<?php

namespace App\Models;

use App\Models\Pivots\Classes;
use App\Models\Pivots\StudentClassMarks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Student  extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable ;
    protected $dateFormat="Y-m-d H:i:s";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $guarded=[
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'created_at',
        "updated_at",
        'password_rested_at',
        'email_verified_at'
    ];

    // Rest omitted for brevity
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            "role"=>'student'
        ];
    }

    //relations ----------------------------------------start--------------------------------------------
    public function Student_Teachers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Teacher::class,'classes','student_id','teacher_id')
            ->using(Classes::class)
            ->as('class')
            ->withPivot('id as class_id','classroom_id','teaching_subject','first_term','mid_term','final_term')
            ->withTimestamps();
    }


   public function Student_Classes() {
       return $this->belongsToMany(ClassRoom::class,'classes','student_id','classroom_id')
           ->using(Classes::class)
           ->as('class')
           ->withPivot('id as class_id','classroom_id','teaching_subject','first_term','mid_term','final_term')
           ->withTimestamps();
    }

   public  function Materials(){
       return $this->hasManyThrough(ClassMaterials::class, Classes::class,
           'student_id',
           'classroom_id',
           'id',
           'classroom_id');
   }
    //relations ----------------------------------------end--------------------------------------------

}
