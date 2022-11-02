<?php

namespace Domain\Banners\DataTransferObjects;

use App\Enums\StatusEnum;
use Domain\Banners\Models\Banner;
use Spatie\DataTransferObject\DataTransferObject;

class BannerData extends DataTransferObject
{
    public ?int $id;

    public int $page_id;

    public ?int $language_id;

    public ?bool $transmission;

    public string $title;

    public ?string $description;

    public ?string $url;

    public ?string $link_text;

    public int $sort;

    public StatusEnum $status;

    public static function fromModel(Banner $banner): BannerData
    {
        return new self(
            id: $banner->id ?? null,
            page_id: $banner->page_id,
            language_id: $banner->language_id ?? null,
            transmission: $banner->transmission,
            title: $banner->title,
            description: $banner->description,
            url: $banner->url,
            link_text: $banner->link_text,
            sort: $banner->sort,
            status: StatusEnum::from($banner->status->value ?? $banner->status),
        );
    }
}
