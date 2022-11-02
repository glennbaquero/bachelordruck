<?php

namespace Domain\Pages\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;
use Domain\Pages\Enums\TargetTypeEnum;

enum PageLanguageFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case PAGE_ID = 'page_id';
    case LANGUAGE_ID = 'language_id';
    case URL = 'url';
    case TARGET_TYPE = 'target_type';
    case NAME = 'name';
    case TITLE = 'title';
    case LAYOUT_ID = 'layout_id';
    case DESCRIPTION = 'description';
    case ACTIVE = 'active';
    case VISIBLE = 'visible';

    public function payload(): array
    {
        return match ($this) {
            self::TARGET_TYPE => [
                'enum' => TargetTypeEnum::class,
            ],
            default => []
        };
    }
}
