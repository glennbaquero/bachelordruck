<?php

namespace Domain\Containers\DataTransferObjects;

use Domain\Containers\Enums\ContainerStatusEnum;
use Domain\Containers\Enums\ContainerTypeEnum;
use Domain\Containers\Models\Container;
use Spatie\DataTransferObject\DataTransferObject;

class ContainerData extends DataTransferObject
{
    public int $sort;

    public ?string $title;

    public ?string $image_alignment;

    public ?string $content;

    public ContainerTypeEnum $type;

    public ?string $options;

    public int $pages_language_id;

    public ?string $url;

    public ?int $source_container_id;

    public ContainerStatusEnum $status;

    public static function fromModel(Container $container): ContainerData
    {
        return new self(
            sort: $container->sort,
            title: $container->title ?? null,
            image_alignment: $container->image_alignment ?? null,
            content: $container->content ?? null,
            type: $container->type,
            options: $container->options ?? null,
            pages_language_id: $container->pages_language_id,
            url: $container->url ?? null,
            source_container_id: $container->source_container_id ?? null,
            status: $container->status ?? ContainerStatusEnum::READY,
        );
    }
}
