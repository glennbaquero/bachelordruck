<?php

namespace Domain\Banners\ShowGrids;

use App\Enums\StatusEnum;
use App\Livewire\View\Fieldset;
use Domain\Banners\FieldEnums\BannerFieldEnum;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\Page;
use Support\Creators\OutputFieldCreator;

class BannerShowGrid
{
    private string $modelName = 'banner';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(field: BannerFieldEnum::ID),
                $fieldCreator->select(field: BannerFieldEnum::PAGE_ID, options: Page::getSelectTree()),
                $fieldCreator->select(field: BannerFieldEnum::LANGUAGE_ID, options: Language::all()
                                                                                            ->toArray()),
                $fieldCreator->checkbox(field: BannerFieldEnum::TRANSMISSION),
                $fieldCreator->text(field: BannerFieldEnum::TITLE),
                $fieldCreator->editor(field: BannerFieldEnum::DESCRIPTION),
                $fieldCreator->text(field: BannerFieldEnum::URL),
                $fieldCreator->text(field: BannerFieldEnum::LINK_TEXT),
                $fieldCreator->text(field: BannerFieldEnum::SORT),
                $fieldCreator->select(field: BannerFieldEnum::STATUS, options: StatusEnum::options()),
            ]),
        ];
    }
}
