<?php

namespace Database\Seeders\PageSeeders\FooterNavigation;

use Database\Seeders\PageSeeders\BasePageSeeder;

class Zahlungsarten extends BasePageSeeder
{
    public function definition(): array
    {
        return [
            'page_id' => null,
            'name' => 'Zahlungsarten',
            'title' => 'Zahlungsarten',
            'url' => '/zahlungsarten',
            'language_id' => $this->language()->id,
            'layout_id' => null,
            'active' => false,
            'visible' => false,
            'parent_name' => 'Footer Navigation',
        ];
    }
}
