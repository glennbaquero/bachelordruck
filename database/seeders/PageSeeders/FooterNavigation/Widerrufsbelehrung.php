<?php

namespace Database\Seeders\PageSeeders\FooterNavigation;

use Database\Seeders\PageSeeders\BasePageSeeder;

class Widerrufsbelehrung extends BasePageSeeder
{
    public function definition(): array
    {
        return [
            'page_id' => null,
            'name' => 'Widerrufsbelehrung',
            'title' => 'Widerrufsbelehrung',
            'url' => '/widerrufsbelehrung',
            'language_id' => $this->language()->id,
            'layout_id' => null,
            'active' => false,
            'visible' => false,
            'parent_name' => 'Footer Navigation',
        ];
    }
}
