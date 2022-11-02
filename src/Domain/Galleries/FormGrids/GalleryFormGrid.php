<?php

namespace Domain\Galleries\FormGrids;

use App\Enums\StatusEnum;
use App\Livewire\View\Fieldset;
use Domain\Galleries\FieldEnums\GalleryFieldEnum;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\Page;
use Support\Creators\FormFieldCreator;

class GalleryFormGrid
{
    private string $modelName = 'gallery';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        $pages = Page::with('pagesLanguage.language')->get();

        return [
            Fieldset::make(
                fields: [
                    $fieldCreator->select(GalleryFieldEnum::LANGUAGE_ID, options: Language::all()->toArray()),
                    $fieldCreator->select(GalleryFieldEnum::PAGE_ID, options: $pages->toArray()),
                    $fieldCreator->text(GalleryFieldEnum::TITLE, defer: false),
                    $fieldCreator->text(GalleryFieldEnum::SLUG),
                    $fieldCreator->editor(GalleryFieldEnum::DESCRIPTION),
                    $fieldCreator->select(GalleryFieldEnum::STATUS, options: StatusEnum::options()),
                    $fieldCreator->decimal(GalleryFieldEnum::SORT),
                    $fieldCreator->upload(GalleryFieldEnum::IMAGE, label: 'Image', rules: 'mimes:jpeg,jpg,png|max:65536', mediaCollectionName: 'image', customProperty: true),
                    $fieldCreator->upload(GalleryFieldEnum::IMAGES, label: 'Images', rules: 'mimes:jpeg,jpg,png|max:65536', mediaCollectionName: 'images', multiple: true, customProperty: true),
                    $fieldCreator->upload(GalleryFieldEnum::PDF, label: 'PDF', rules: 'mimes:pdf|max:65536', mediaCollectionName: 'pdf', multiple: false),
                ]
            ),
        ];
    }
}
