<?php

namespace App\View\Editor;

use App\View\Components\Svg;

class MenuItem
{
    public function __construct(
        public string $action,
        public ?string $active,
        public ?bool $disabled,
        public Svg $svg
    ) {
    }

    public static function create(
        string $action,
        Svg $svg,
        string $active = null,
        bool $disabled = null,
    ): MenuItem {
        return new self(
            action: $action,
            active: $active,
            disabled: $disabled,
            svg: $svg
        );
    }
}
