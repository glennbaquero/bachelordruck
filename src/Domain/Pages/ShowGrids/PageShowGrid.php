<?php

namespace Domain\Pages\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Pages\Enums\TargetTypeEnum;
use Domain\Pages\FieldEnums\PageLanguageFieldEnum;
use Support\Creators\OutputFieldCreator;

class PageShowGrid
{
    private string $modelName = 'pagelanguage';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(field: PageLanguageFieldEnum::LANGUAGE_ID),
                $fieldCreator->url(field: PageLanguageFieldEnum::URL),
                $fieldCreator->select(PageLanguageFieldEnum::TARGET_TYPE, options: TargetTypeEnum::options()),
                $fieldCreator->text(field: PageLanguageFieldEnum::NAME),
                $fieldCreator->text(field: PageLanguageFieldEnum::TITLE),
                $fieldCreator->text(field: PageLanguageFieldEnum::LAYOUT_ID),
                $fieldCreator->text(field: PageLanguageFieldEnum::DESCRIPTION),
                $fieldCreator->checkbox(field: PageLanguageFieldEnum::ACTIVE),
                $fieldCreator->checkbox(field: PageLanguageFieldEnum::VISIBLE),
            ]),
        ];
    }
}
