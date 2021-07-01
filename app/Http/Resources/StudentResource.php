<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'classroom_id'=>$this->class->classroom_id,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'first_term'=>$this->class->first_term,
            'mid_term'=>$this->class->mid_term,
            'final_term'=>$this->class->final_term
        ];
    }
}
