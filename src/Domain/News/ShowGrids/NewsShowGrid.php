<?php

namespace Domain\News\ShowGrids;

use App\Enums\StatusEnum;
use App\Livewire\View\Fieldset;
use Domain\News\FieldEnums\NewsFieldEnum;
use Domain\Pages\Models\Language;
use Support\Creators\OutputFieldCreator;

class NewsShowGrid
{
    private string $modelName = 'news';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->select(field: NewsFieldEnum::LANGUAGE_ID, options: Language::all()->toArray()),
                $fieldCreator->text(field: NewsFieldEnum::TITLE),
                $fieldCreator->text(field: NewsFieldEnum::SLUG),
                $fieldCreator->text(field: NewsFieldEnum::DESCRIPTION),
                $fieldCreator->date(field: NewsFieldEnum::NEWS_DATE),
                $fieldCreator->text(field: NewsFieldEnum::VIDEO_URL),
                $fieldCreator->enum(field: NewsFieldEnum::STATUS, enum: StatusEnum::class),
            ]),
        ];
    }
}
