<?php

namespace App\News\Resources;

use App\Media\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'video_url' => $this->video_url,
            'news_date' => $this->news_date,
            'status' => $this->status,
            'image' => new MediaResource($this->getMedia('image')->first()),
            'images' => MediaResource::collection($this->getMedia('images')),
            'pdfs' => MediaResource::collection($this->getMedia('pdf')),
        ];
    }
}
