<?php

namespace Domain\Galleries\ShowGrids;

use App\Enums\StatusEnum;
use App\Livewire\View\Fieldset;
use Domain\Galleries\FieldEnums\GalleryFieldEnum;
use Domain\Pages\Models\Language;
use Support\Creators\OutputFieldCreator;

class GalleryShowGrid
{
    private string $modelName = 'gallery';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->select(field: GalleryFieldEnum::LANGUAGE_ID, options: Language::all()->toArray()),
                $fieldCreator->text(field: GalleryFieldEnum::TITLE),
                $fieldCreator->text(field: GalleryFieldEnum::DESCRIPTION),
                $fieldCreator->enum(field: GalleryFieldEnum::STATUS, enum: StatusEnum::class),
                $fieldCreator->text(field: GalleryFieldEnum::SORT),
            ]),
        ];
    }
}
