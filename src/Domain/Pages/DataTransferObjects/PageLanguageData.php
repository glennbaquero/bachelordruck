<?php

namespace Domain\Pages\DataTransferObjects;

use Domain\Pages\Enums\TargetTypeEnum;
use Domain\Pages\Models\PageLanguage;
use Spatie\DataTransferObject\DataTransferObject;

class PageLanguageData extends DataTransferObject
{
    public ?int $page_id;

//    public ?int $parent_id;
    public ?int $language_id;

    public ?string $url;

    public TargetTypeEnum $target_type = TargetTypeEnum::CONTENT;

    public string $name;

    public string $title;

    public ?int $layout_id;

    public ?string $description;

    public ?bool $active = true;

    public ?bool $visible = true;

    public function __construct(...$args)
    {
        if (empty($args['title'])) {
            $args['title'] = $args['name'];
        }
        parent::__construct($args);
    }

    public static function fromModel(PageLanguage $pageLanguage): PageLanguageData
    {
        return new self(
            page_id: $pageLanguage->page_id,
            language_id: $pageLanguage->language_id,
            url: $pageLanguage->url,
            target_type: $pageLanguage->target_type,
            name: $pageLanguage->name,
            title: $pageLanguage->title,
            layout_id: $pageLanguage->layout_id,
            description: $pageLanguage->description,
            active: $pageLanguage->active ?? true,
            visible: $pageLanguage->visible ?? true
        );
    }
}
