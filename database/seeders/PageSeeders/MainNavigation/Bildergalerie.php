<?php

namespace Database\Seeders\PageSeeders\MainNavigation;

use Database\Seeders\PageSeeders\BasePageSeeder;

class Bildergalerie extends BasePageSeeder
{
    protected ?string $parentName = 'Main Navigation';

    public function definition(): array
    {
        return [
            'page_id' => null,
            'name' => 'Bildergalerie',
            'title' => 'Bildergalerie',
            'url' => '/bildergalerie',
            'language_id' => $this->language()->id,
            'layout_id' => $this->layout('bachelordruck.gallery')?->id,
            'active' => true,
            'visible' => true,
            'parent_name' => $this->parentName,
        ];
    }
}
