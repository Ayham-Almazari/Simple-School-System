<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
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
            "classroom_id"=>$this->classroom_id,
            "material"=>$this->material,
            "material_description"=>$this->material_description,
            "updated_at"=>$this->created_at->diffForHumans()
        ];
    }
}
