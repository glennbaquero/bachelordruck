<?php

namespace Database\Seeders\PageSeeders\MainNavigation;

use Database\Seeders\PageSeeders\BasePageSeeder;

class Kontakt extends BasePageSeeder
{
    protected ?string $parentName = 'Main Navigation';

    public function definition(): array
    {
        return [
            'page_id' => null,
            'name' => 'Kontakt',
            'title' => 'Kontakt',
            'url' => '/kontakt',
            'language_id' => $this->language()->id,
            'layout_id' => $this->layout('bachelordruck.contact')->id,
            'active' => true,
            'visible' => true,
            'parent_name' => 'Main Navigation',
        ];
    }
}
