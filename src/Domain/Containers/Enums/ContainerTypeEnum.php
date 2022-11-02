<?php

namespace Domain\Containers\Enums;

use App\Traits\EnumSelectable;
use Domain\Containers\Models\Container;
use Domain\Containers\Rules\ContainerHeadlineTextImageRules;
use Domain\Containers\Rules\ContainerHeadlineTextRules;
use Domain\Containers\Rules\ContainerHeadlineTextYoutubeVideoRules;
use Domain\Containers\Rules\ContainerImageRules;
use Domain\Containers\Rules\ContainerYoutubeVideoRules;
use Illuminate\Database\Eloquent\Collection;

enum ContainerTypeEnum: string
{
    use EnumSelectable;

    case HEADLINE_TEXT = 'headline_text';
    case HEADLINE_TEXT_IMAGE = 'headline_text_image';
    case HEADLINE_TEXT_YOUTUBE_VIDEO = 'headline_text_youtube_video';
    case IMAGE = 'image';
    case YOUTUBE_VIDEO = 'youtube_video';

    public function getBackendView(): string
    {
        return 'livewire.pages.backend.'.$this->value;
    }

    public function getFrontendComponent(): ?string
    {
        return config('cms.containers.'.$this->value);
    }

    public function hasImage(): bool
    {
        return match ($this) {
            self::HEADLINE_TEXT_IMAGE, self::IMAGE => true,
            default => false,
        };
    }

    public function getRules(): array
    {
        return match ($this) {
            self::HEADLINE_TEXT => ContainerHeadlineTextRules::getRules(),
            self::HEADLINE_TEXT_IMAGE => ContainerHeadlineTextImageRules::getRules(),
            self::HEADLINE_TEXT_YOUTUBE_VIDEO => ContainerHeadlineTextYoutubeVideoRules::getRules(),
            self::IMAGE => ContainerImageRules::getRules(),
            self::YOUTUBE_VIDEO => ContainerYoutubeVideoRules::getRules(),
        };
    }

    public function getDefaultContainer(Collection $containers, int $pagesLanguageId): Container
    {
        $container = new Container([
            'title' => null,
            'content' => null,
            'image_alignment' => null,
            'sort' => $containers->count() + 1,
            'pages_language_id' => $pagesLanguageId,
            'type' => $this,
            'url' => null,
        ]);

        return match ($this) {
            self::HEADLINE_TEXT_IMAGE, self::IMAGE => $this->getImageContainer($container),

            default => $container,
        };
    }

    protected function getImageContainer(Container $container): Container
    {
        $container->image_alignment = 'right';

        return $container;
    }

    public function translatableFields(): array
    {
        return match ($this) {
            self::HEADLINE_TEXT,
            self::HEADLINE_TEXT_IMAGE => ['title', 'content'],
            default => [],
        };
    }
}
