<?php

namespace Database\Seeders\PageSeeders\MainNavigation;

use Database\Seeders\PageSeeders\BasePageSeeder;

class Preise extends BasePageSeeder
{
    protected ?string $parentName = 'Main Navigation';

    public function definition(): array
    {
        return [
            'page_id' => null,
            'name' => 'Preise',
            'title' => 'Preise',
            'url' => '/preise',
            'language_id' => $this->language()->id,
            'layout_id' => $this->layout('bachelordruck.price')?->id,
            'active' => true,
            'visible' => true,
            'parent_name' => 'Main Navigation',
        ];
    }
}
