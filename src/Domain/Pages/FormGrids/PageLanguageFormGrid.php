<?php

namespace Domain\Pages\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Pages\Enums\TargetTypeEnum;
use Domain\Pages\FieldEnums\PageFieldEnum;
use Domain\Pages\FieldEnums\PageLanguageFieldEnum;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\Layout;
use Domain\Pages\Models\Page;
use Support\Creators\FormFieldCreator;

class PageLanguageFormGrid
{
    private string $modelName = 'pageLanguage';

    public function __invoke(bool $isUpdate = false, bool $hideParent = false): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        $fields = [];
        if (! $isUpdate) {
            $fields[] = $fieldCreator->hidden(PageLanguageFieldEnum::PAGE_ID);
            if (! $hideParent) {
                $fieldCreator->setModel('page');
                $fields[] = $fieldCreator->select(PageFieldEnum::PARENT_ID, label:__('pageFields.'.PageFieldEnum::PARENT_ID->value))->options(Page::getSelectTree());
                $fieldCreator->setModel($this->modelName);
            }

            $fields[] = $fieldCreator->select(PageLanguageFieldEnum::LANGUAGE_ID)->options(Language::all()->toArray());
        }
        $fields[] = $fieldCreator->text(PageLanguageFieldEnum::NAME, defer: false);
        $fields[] = $fieldCreator->text(PageLanguageFieldEnum::TITLE);
        $fields[] = $fieldCreator->select(PageLanguageFieldEnum::TARGET_TYPE, options: TargetTypeEnum::options());
        $fields[] = $fieldCreator->text(PageLanguageFieldEnum::URL);

        $fields[] = $fieldCreator->select(PageLanguageFieldEnum::LAYOUT_ID)->options(Layout::all()->toArray());
        $fields[] = $fieldCreator->textarea(PageLanguageFieldEnum::DESCRIPTION);
        $fields[] = $fieldCreator->checkbox(PageLanguageFieldEnum::ACTIVE);
        $fields[] = $fieldCreator->checkbox(PageLanguageFieldEnum::VISIBLE);

        return [
            Fieldset::make(fields: $fields),
        ];
    }
}
