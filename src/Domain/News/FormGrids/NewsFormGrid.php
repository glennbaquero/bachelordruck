<?php

namespace Domain\News\FormGrids;

use App\Enums\StatusEnum;
use App\Livewire\View\Fieldset;
use Domain\News\FieldEnums\NewsFieldEnum;
use Domain\Pages\Models\Language;
use Support\Creators\FormFieldCreator;

class NewsFormGrid
{
    private string $modelName = 'news';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(
                fields: [
                    $fieldCreator->select(NewsFieldEnum::LANGUAGE_ID, options: Language::all()->toArray()),
                    $fieldCreator->text(NewsFieldEnum::TITLE, defer: false),
                    $fieldCreator->text(NewsFieldEnum::SLUG),
                    $fieldCreator->textarea(NewsFieldEnum::DESCRIPTION),
                    $fieldCreator->text(NewsFieldEnum::VIDEO_URL),
                    $fieldCreator->date(NewsFieldEnum::NEWS_DATE),
                    $fieldCreator->select(NewsFieldEnum::STATUS, options: StatusEnum::options()),
                    $fieldCreator->upload(NewsFieldEnum::IMAGE, label: 'Image', rules: 'mimes:jpeg,jpg,png|max:65536', mediaCollectionName: 'image'),
                    $fieldCreator->upload(NewsFieldEnum::IMAGES, label: 'Images', rules: 'mimes:jpeg,jpg,png|max:65536', mediaCollectionName: 'images', multiple: true),
                    $fieldCreator->upload(NewsFieldEnum::PDF, label: 'PDF', rules: 'mimes:pdf|max:65536', mediaCollectionName: 'pdf', multiple: false),
                ]
            ),
        ];
    }
}
