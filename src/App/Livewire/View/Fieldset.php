<?php

namespace App\Livewire\View;

use JetBrains\PhpStorm\Pure;

class Fieldset
{
    public function __construct(
        public string $title = '',
        public array $fields = [],
        public bool $showTitle = true,
    ) {
    }

    #[Pure]
 public static function make(string $title = '', array $fields = [], bool $showTitle = true): Fieldset
 {
     return new static(title: $title, fields: $fields, showTitle: $showTitle);
 }
}
