<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseSubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Original implementation that returns all fields from the model.
        // Uncomment this line if you want to include all fields.
        // return parent::toArray($request);

        // Custom implementation to return only 'id' and 'title' fields.
        return [
            "id" => $this->id,
            "title" => $this->subject->title ?? '',
        ];
    }
}
