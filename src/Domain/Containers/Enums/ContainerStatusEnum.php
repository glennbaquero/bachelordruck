<?php

namespace Domain\Containers\Enums;

use App\Traits\EnumSelectable;

enum ContainerStatusEnum: string
{
    use EnumSelectable;

    case READY = 'ready';
    case COPYING = 'copying';
    case TRANSLATING = 'translating';

    public function notReady(): bool
    {
        return match ($this) {
            self::READY => false,
            default => true,
        };
    }
}
