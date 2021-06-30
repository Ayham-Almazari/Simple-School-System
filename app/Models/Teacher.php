<?php

namespace App\Models;

use App\Models\Pivots\Classes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Teacher extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $dateFormat = "Y-m-d H:i:s";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $guarded = [

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
            "role" => 'teacher'
        ];
    }

    //relations ----------------------------------------start--------------------------------------------
    public function Teacher_Students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'classes', 'teacher_id', 'student_id')
            ->using(Classes::class)
            ->as('class')
            ->withPivot('id as class_id', 'teaching_subject', 'first_term', 'mid_term', 'final_term')
            ->withTimestamps();
    }

    public function Teacher_classes(): HasMany
    {
        return $this->hasMany(ClassRoom::class, 'teacher_id');
    }

    public function Materials(): HasManyThrough
    {
        return $this->hasManyThrough(ClassMaterials::class, ClassRoom::class,
            'teacher_id',
            'classroom_id',
            'id',
            'id');
    }
    //relations ----------------------------------------end--------------------------------------------


}
