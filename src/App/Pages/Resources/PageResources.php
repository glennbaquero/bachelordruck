<?php

namespace App\Pages\Resources;

use App\Languages\Resources\LanguageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResources extends JsonResource
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
            'language' => new LanguageResource($this->language),
            'url' => $this->url,
            'target_type' => $this->target_type,
            'name' => $this->name,
            'title' => $this->title,
            'layout_id' => $this->layout_id,
            'description' => $this->description,
            'active' => $this->active,
            'visible' => $this->visible,
            'containers' => ContainerResource::collection($this->containers),
        ];
    }
}
