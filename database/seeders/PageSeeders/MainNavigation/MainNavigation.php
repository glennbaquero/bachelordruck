<?php

namespace Database\Seeders\PageSeeders\MainNavigation;

use Database\Seeders\PageSeeders\BasePageSeeder;

class MainNavigation extends BasePageSeeder
{
    public function definition(): array
    {
        return [
            'page_id' => null,
            'name' => 'Main Navigation',
            'title' => 'Main Navigation',
            'url' => '',
            'language_id' => $this->language()->id,
            'layout_id' => null,
            'active' => false,
            'visible' => false,
            'parent_name' => null,
        ];
    }
}
