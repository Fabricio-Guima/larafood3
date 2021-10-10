<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name'  => $this->name,
            'identify'   => $this->uuid,
            'image' => $this->image ? url("storage/{$this->image}") : null,
            'price' => $this->price,
            'description' => $this->description,
           
        ];
    }
}
