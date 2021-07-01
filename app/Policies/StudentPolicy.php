<?php

namespace App\Policies;

use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class StudentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Student  $student
     * @return mixed
     */
    public function viewAny(Student $student)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Student  $student
     * @param  \App\Models\Student  $student
     * @return mixed
     */
    public function view($user, Student $student)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Student  $student
     * @return mixed
     */
    public function create(Student $student)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Student  $student
     * @param  \App\Models\Student  $student
     * @return mixed
     */
    public function update($user, Student $student)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Student  $student
     * @param  \App\Models\Student  $student
     * @return mixed
     */
    public function delete($user, Student $student)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Student  $student
     * @param  \App\Models\Student  $student
     * @return mixed
     */
    public function restore($user, Student $student)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Student  $student
     * @param  \App\Models\Student  $student
     * @return mixed
     */
    public function forceDelete( $user, Student $student)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Student  $student
     * @param  \App\Models\ClassRoom  $classRoom
     * @return mixed
     */
    public function authorize_student_for_teacher( $teacher, ClassRoom $classRoom)
    {
        //if cart is empty authorized
        if ($teacher->id === $classRoom->teacher_id)
            return Response::allow();
        else
            //if the buyer tried to add product from another factory then unauthorized
            return Response::deny("Just The Owner Teacher Can Access This Classroom .");

    }

}
