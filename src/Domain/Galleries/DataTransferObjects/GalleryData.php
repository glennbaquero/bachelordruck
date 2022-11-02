<?php

namespace Domain\Galleries\DataTransferObjects;

use App\Enums\StatusEnum;
use Domain\Galleries\Models\Gallery;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

class GalleryData extends DataTransferObject
{
    public int $language_id;

    public ?int $page_id;

    public string $title;

    public ?string $description;

    public StatusEnum $status;

    public int $sort;

    public string $slug;

    public static function fromModel(Gallery $gallery): GalleryData
    {
        return new self(
            language_id: $gallery->language_id,
            page_id: $gallery->page_id ?? null,
            title: $gallery->title,
            description: $gallery->description,
            status: StatusEnum::from($gallery->status->value ?? $gallery->status),
            sort: $gallery->sort,
            slug: $gallery->slug ?? Str::slug($gallery->title),
        );
    }
}
