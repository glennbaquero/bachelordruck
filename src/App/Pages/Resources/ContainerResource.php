<?php

namespace App\Pages\Resources;

use App\Media\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContainerResource extends JsonResource
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
            'sort' => $this->sort,
            'headline' => $this->headline ?? null,
            'image_alignment' => $this->image_alignment ?? null,
            'content' => $this->content ?? null,
            'type' => $this->type,
            'options' => $this->options ?? null,
            'images' => MediaResource::collection($this->getMedia('images')),
        ];
    }
}
