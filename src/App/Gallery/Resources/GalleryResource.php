<?php

namespace App\Gallery\Resources;

use App\Media\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
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
            'language_id' => $this->language_id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'image' => new MediaResource($this->getMedia('image')->first()),
            'images' => MediaResource::collection($this->getMedia('images')),
        ];
    }
}
