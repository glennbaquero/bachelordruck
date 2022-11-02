<?php

namespace Domain\Banners\FormGrids;

use App\Enums\StatusEnum;
use App\Livewire\View\Fieldset;
use Domain\Banners\FieldEnums\BannerFieldEnum;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\Page;
use Support\Creators\FormFieldCreator;

class BannerFormGrid
{
    private string $modelName = 'banner';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->select(BannerFieldEnum::PAGE_ID, options: Page::getSelectTree()),
                $fieldCreator->select(BannerFieldEnum::LANGUAGE_ID, options: Language::all()->toArray()),
                $fieldCreator->checkbox(BannerFieldEnum::TRANSMISSION),
                $fieldCreator->text(BannerFieldEnum::TITLE),
                $fieldCreator->editor(BannerFieldEnum::DESCRIPTION),
                $fieldCreator->text(BannerFieldEnum::URL),
                $fieldCreator->text(BannerFieldEnum::LINK_TEXT),
                $fieldCreator->select(BannerFieldEnum::STATUS, options: StatusEnum::options()),
                $fieldCreator->decimal(BannerFieldEnum::SORT),
                $fieldCreator->upload(BannerFieldEnum::IMAGE, label: 'Image', rules: 'mimes:jpeg,jpg,png|max:65536', mediaCollectionName: 'image', multiple: true),
            ]),
        ];
    }
}
