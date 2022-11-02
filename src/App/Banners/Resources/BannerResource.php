<?php

namespace App\Banners\Resources;

use App\Media\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
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
            'page_id' => $this->page_id,
            'language_id' => $this->language_id,
            'transmission' => $this->transmission,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'link_text' => $this->link_text,
            'sort' => $this->sort,
            'status' => $this->status,
            'image' => new MediaResource($this->getMedia('image')->first()),
        ];
    }
}
